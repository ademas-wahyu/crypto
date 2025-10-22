<?php

namespace App\Http\Controllers;

use App\Models\Cryptocurrency;

class MarketController extends Controller
{
    public function index()
    {
        $cryptocurrencies = Cryptocurrency::query()
            ->where('is_active', true)
            ->orderBy('rank')
            ->get();

        $trending = Cryptocurrency::query()
            ->where('is_active', true)
            ->orderByDesc('volume_24h')
            ->take(10)
            ->get();

        $topGainers = Cryptocurrency::query()
            ->where('is_active', true)
            ->orderByDesc('change_percent_24h')
            ->take(10)
            ->get();

        $topLosers = Cryptocurrency::query()
            ->where('is_active', true)
            ->orderBy('change_percent_24h')
            ->take(10)
            ->get();

        return view('market.index', [
            'cryptocurrencies' => $cryptocurrencies,
            'trending' => $trending,
            'topGainers' => $topGainers,
            'topLosers' => $topLosers,
        ]);
    }
}
