<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CoinGeckoClient
{
    private string $baseUrl;
    private int $timeout;
    private string $currency;

    public function __construct()
    {
        $config = config('crypto.coingecko');
        $this->baseUrl = rtrim($config['base_url'] ?? 'https://api.coingecko.com/api/v3', '/');
        $this->timeout = (int) ($config['timeout'] ?? 10);
        $this->currency = strtolower($config['default_currency'] ?? 'usd');
    }

    /**
     * @return array<string, mixed>
     */
    public function price(string $id): array
    {
        $cacheTtl = $this->ttl('price');
        $cacheKey = sprintf('coingecko.price.%s.%s', $id, $this->currency);

        return Cache::remember($cacheKey, $cacheTtl, function () use ($id) {
            $response = $this->request('simple/price', [
                'ids' => $id,
                'vs_currencies' => $this->currency,
                'include_24hr_change' => 'true',
                'include_last_updated_at' => 'true',
            ]);

            $price = $response[$id][$this->currency] ?? null;
            $change = $response[$id][$this->currency . '_24h_change'] ?? null;
            $updatedAt = $response[$id]['last_updated_at'] ?? null;

            return [
                'price' => $price,
                'changePercent' => $change,
                'timestamp' => $updatedAt ? Carbon::createFromTimestamp($updatedAt)->timestamp : now()->timestamp,
            ];
        });
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function market(array $ids = [], array $params = []): array
    {
        $payload = array_merge([
            'vs_currency' => $this->currency,
            'order' => 'market_cap_desc',
            'per_page' => 50,
            'page' => 1,
            'price_change_percentage' => '1h,24h,7d',
        ], $params);

        if (! empty($ids)) {
            $payload['ids'] = implode(',', $ids);
        }

        $cacheKey = sprintf('coingecko.market.%s', md5(json_encode($payload)));

        return Cache::remember($cacheKey, $this->ttl('market'), function () use ($payload) {
            return $this->request('coins/markets', $payload);
        });
    }

    /**
     * @return array<int, array{timestamp:int,date:string,price:float,volume:float}>
     */
    public function historical(string $id, string $range): array
    {
        $daysMap = [
            '1d' => 1,
            '7d' => 7,
            '30d' => 30,
            '90d' => 90,
            '1y' => 365,
        ];

        $days = $daysMap[$range] ?? 7;
        $cacheKey = sprintf('coingecko.historical.%s.%d', $id, $days);

        return Cache::remember($cacheKey, $this->ttl('historical'), function () use ($id, $days) {
            $response = $this->request("coins/{$id}/market_chart", [
                'vs_currency' => $this->currency,
                'days' => $days,
            ]);

            $prices = $response['prices'] ?? [];
            $volumes = Arr::pluck($response['total_volumes'] ?? [], 1, 0);

            $history = [];
            foreach ($prices as $entry) {
                [$timestamp, $price] = $entry;
                $volume = $volumes[$timestamp] ?? null;
                $history[] = [
                    'timestamp' => (int) $timestamp,
                    'date' => Carbon::createFromTimestampMs($timestamp)->format('Y-m-d H:i'),
                    'price' => (float) $price,
                    'volume' => $volume !== null ? (float) $volume : null,
                ];
            }

            return $history;
        });
    }

    private function ttl(string $key): int
    {
        $ttl = config('crypto.coingecko.cache.ttl.' . $key, 60);

        return $ttl > 0 ? $ttl : 60;
    }

    /**
     * @param  array<string, scalar>  $params
     * @return array<string, mixed>
     */
    private function request(string $endpoint, array $params = []): array
    {
        $response = Http::baseUrl($this->baseUrl)
            ->timeout($this->timeout)
            ->acceptJson()
            ->get($endpoint, $params);

        $response->throw();

        return $response->json();
    }
}
