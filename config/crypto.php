<?php

return [
    'coingecko' => [
        'base_url' => env('COINGECKO_API_BASE', 'https://api.coingecko.com/api/v3'),
        'pro_base_url' => env('COINGECKO_API_PRO_BASE', 'https://pro-api.coingecko.com/api/v3'),
        'api_key' => env('COINGECKO_API_KEY', ''),
        'timeout' => (int) env('COINGECKO_API_TIMEOUT', 10),
        'cache' => [
            'ttl' => [
                'price' => (int) env('COINGECKO_CACHE_TTL_PRICE', 30),
                'market' => (int) env('COINGECKO_CACHE_TTL_MARKET', 120),
                'historical' => (int) env('COINGECKO_CACHE_TTL_HISTORICAL', 600),
            ],
        ],
        'default_currency' => env('COINGECKO_DEFAULT_CURRENCY', 'usd'),
    ],
];
