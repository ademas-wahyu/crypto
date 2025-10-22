<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CryptocurrencySeeder extends Seeder
{
    public function run(): void
    {
        $cryptos = [
            [
                'symbol' => 'BTC',
                'name' => 'Bitcoin',
                'coingecko_id' => 'bitcoin',
                'current_price' => 45000.00,
                'market_cap' => 878000000000,
                'volume_24h' => 28000000000,
                'change_24h' => 1250.50,
                'change_percent_24h' => 2.85,
                'rank' => 1,
                'is_active' => true,
            ],
            [
                'symbol' => 'ETH',
                'name' => 'Ethereum',
                'coingecko_id' => 'ethereum',
                'current_price' => 2450.75,
                'market_cap' => 294000000000,
                'volume_24h' => 15000000000,
                'change_24h' => -45.25,
                'change_percent_24h' => -1.81,
                'rank' => 2,
                'is_active' => true,
            ],
            [
                'symbol' => 'BNB',
                'name' => 'Binance Coin',
                'coingecko_id' => 'binancecoin',
                'current_price' => 315.40,
                'market_cap' => 48000000000,
                'volume_24h' => 1200000000,
                'change_24h' => 8.75,
                'change_percent_24h' => 2.85,
                'rank' => 3,
                'is_active' => true,
            ],
            [
                'symbol' => 'SOL',
                'name' => 'Solana',
                'coingecko_id' => 'solana',
                'current_price' => 98.25,
                'market_cap' => 42000000000,
                'volume_24h' => 2800000000,
                'change_24h' => 5.50,
                'change_percent_24h' => 5.92,
                'rank' => 4,
                'is_active' => true,
            ],
            [
                'symbol' => 'ADA',
                'name' => 'Cardano',
                'coingecko_id' => 'cardano',
                'current_price' => 0.58,
                'market_cap' => 20000000000,
                'volume_24h' => 450000000,
                'change_24h' => -0.02,
                'change_percent_24h' => -3.33,
                'rank' => 5,
                'is_active' => true,
            ],
            [
                'symbol' => 'XRP',
                'name' => 'Ripple',
                'coingecko_id' => 'ripple',
                'current_price' => 0.62,
                'market_cap' => 33000000000,
                'volume_24h' => 1800000000,
                'change_24h' => 0.01,
                'change_percent_24h' => 1.64,
                'rank' => 6,
                'is_active' => true,
            ],
            [
                'symbol' => 'DOT',
                'name' => 'Polkadot',
                'coingecko_id' => 'polkadot',
                'current_price' => 7.85,
                'market_cap' => 10000000000,
                'volume_24h' => 320000000,
                'change_24h' => 0.25,
                'change_percent_24h' => 3.29,
                'rank' => 7,
                'is_active' => true,
            ],
            [
                'symbol' => 'MATIC',
                'name' => 'Polygon',
                'coingecko_id' => 'matic-network',
                'current_price' => 0.92,
                'market_cap' => 8500000000,
                'volume_24h' => 420000000,
                'change_24h' => -0.03,
                'change_percent_24h' => -3.16,
                'rank' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($cryptos as $crypto) {
            DB::table('cryptocurrencies')->insert([
                ...$crypto,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}