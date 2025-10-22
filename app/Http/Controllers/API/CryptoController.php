<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cryptocurrency;
use App\Services\CoinGeckoClient;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Throwable;

class CryptoController extends Controller
{
    public function __construct(private readonly CoinGeckoClient $client)
    {
    }

    public function index()
    {
        $cryptos = Cryptocurrency::where('is_active', true)
            ->orderBy('rank')
            ->get();
            
        return response()->json($cryptos);
    }
    
    public function show($symbol)
    {
        $crypto = Cryptocurrency::where('symbol', strtoupper($symbol))
            ->where('is_active', true)
            ->firstOrFail();
            
        return response()->json($crypto);
    }
    
    public function price($symbol)
    {
        $crypto = Cryptocurrency::where('symbol', strtoupper($symbol))
            ->where('is_active', true)
            ->first();

        if (! $crypto) {
            return response()->json(['error' => 'Cryptocurrency not found'], 404);
        }

        if (! $crypto->coingecko_id) {
            return response()->json(['error' => 'CoinGecko mapping missing for symbol'], 422);
        }

        try {
            $marketData = $this->client->market([$crypto->coingecko_id], ['per_page' => 1]);
        } catch (Throwable $exception) {
            Log::error('Failed to fetch price from CoinGecko', [
                'symbol' => $symbol,
                'exception' => $exception->getMessage(),
            ]);

            return response()->json(['error' => 'Unable to fetch price data'], 502);
        }

        $entry = Arr::first($marketData);

        if (! $entry) {
            return response()->json(['error' => 'Price data not available'], 404);
        }

        $timestamp = isset($entry['last_updated'])
            ? Carbon::parse($entry['last_updated'])->timestamp
            : now()->timestamp;

        return response()->json([
            'symbol' => strtoupper($entry['symbol'] ?? $crypto->symbol),
            'price' => $entry['current_price'] ?? null,
            'change' => $entry['price_change_24h'] ?? null,
            'changePercent' => $entry['price_change_percentage_24h'] ?? null,
            'timestamp' => $timestamp,
        ]);
    }

    public function historical(Request $request, $symbol)
    {
        $crypto = Cryptocurrency::where('symbol', strtoupper($symbol))
            ->where('is_active', true)
            ->firstOrFail();

        if (! $crypto->coingecko_id) {
            return response()->json(['error' => 'CoinGecko mapping missing for symbol'], 422);
        }

        $period = $request->get('period', '7d');

        try {
            $history = $this->client->historical($crypto->coingecko_id, $period);
        } catch (Throwable $exception) {
            Log::error('Failed to fetch historical data from CoinGecko', [
                'symbol' => $symbol,
                'period' => $period,
                'exception' => $exception->getMessage(),
            ]);

            return response()->json(['error' => 'Unable to fetch historical data'], 502);
        }

        return response()->json($history);
    }

    public function trending()
    {
        try {
            $data = $this->client->market([], [
                'order' => 'gecko_desc',
                'per_page' => 10,
                'page' => 1,
            ]);
        } catch (Throwable $exception) {
            Log::error('Failed to fetch trending data from CoinGecko', [
                'exception' => $exception->getMessage(),
            ]);

            return response()->json(['error' => 'Unable to fetch trending data'], 502);
        }

        return response()->json($this->formatMarketResponse($data));
    }

    public function gainers()
    {
        try {
            $data = $this->client->market([], [
                'order' => 'price_change_percentage_24h_desc',
                'per_page' => 20,
                'page' => 1,
            ]);
        } catch (Throwable $exception) {
            Log::error('Failed to fetch gainers from CoinGecko', [
                'exception' => $exception->getMessage(),
            ]);

            return response()->json(['error' => 'Unable to fetch gainers'], 502);
        }

        $filtered = collect($data)
            ->filter(fn ($item) => ($item['price_change_percentage_24h'] ?? 0) > 0)
            ->take(10)
            ->values()
            ->all();

        return response()->json($this->formatMarketResponse($filtered));
    }

    public function losers()
    {
        try {
            $data = $this->client->market([], [
                'order' => 'price_change_percentage_24h_asc',
                'per_page' => 20,
                'page' => 1,
            ]);
        } catch (Throwable $exception) {
            Log::error('Failed to fetch losers from CoinGecko', [
                'exception' => $exception->getMessage(),
            ]);

            return response()->json(['error' => 'Unable to fetch losers'], 502);
        }

        $filtered = collect($data)
            ->filter(fn ($item) => ($item['price_change_percentage_24h'] ?? 0) < 0)
            ->take(10)
            ->values()
            ->all();

        return response()->json($this->formatMarketResponse($filtered));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        
        if (!$query || strlen($query) < 2) {
            return response()->json([]);
        }
        
        $cryptos = Cryptocurrency::where('is_active', true)
            ->where(function($q) use ($query) {
                $q->where('symbol', 'LIKE', '%' . strtoupper($query) . '%')
                  ->orWhere('name', 'LIKE', '%' . $query . '%');
            })
            ->orderBy('rank')
            ->take(20)
            ->get();

        return response()->json($cryptos);
    }

    /**
     * @param  array<int, array<string, mixed>>  $data
     * @return array<int, array<string, mixed>>
     */
    private function formatMarketResponse(array $data): array
    {
        return collect($data)
            ->map(function (array $item) {
                return [
                    'symbol' => strtoupper($item['symbol'] ?? ''),
                    'name' => $item['name'] ?? null,
                    'price' => $item['current_price'] ?? null,
                    'market_cap' => $item['market_cap'] ?? null,
                    'volume_24h' => $item['total_volume'] ?? null,
                    'change_24h' => $item['price_change_24h'] ?? null,
                    'change_percent_24h' => $item['price_change_percentage_24h'] ?? null,
                    'last_updated' => $item['last_updated'] ?? null,
                ];
            })
            ->all();
    }
}