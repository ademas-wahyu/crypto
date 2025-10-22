<?php

namespace App\Http\Controllers;

use App\Models\Cryptocurrency;

class DashboardController extends Controller
{
    public function index()
    {
        $baseQuery = Cryptocurrency::query()->where('is_active', true);

        $stats = [
            'totalMarketCap' => (clone $baseQuery)->sum('market_cap'),
            'totalVolume' => (clone $baseQuery)->sum('volume_24h'),
            'avgChange' => (clone $baseQuery)->avg('change_percent_24h'),
            'activeCount' => (clone $baseQuery)->count(),
        ];

        $trendingCryptos = (clone $baseQuery)
            ->orderByDesc('volume_24h')
            ->take(5)
            ->get();

        $topGainers = (clone $baseQuery)
            ->orderByDesc('change_percent_24h')
            ->take(5)
            ->get();

        $topLosers = (clone $baseQuery)
            ->orderBy('change_percent_24h')
            ->take(5)
            ->get();

        $topByMarketCap = (clone $baseQuery)
            ->orderByDesc('market_cap')
            ->take(5)
            ->get();

        $featuredCrypto = $trendingCryptos->first()
            ?? (clone $baseQuery)->orderBy('rank')->first();

        return view('dashboard.index', [
            'stats' => $stats,
            'featuredCrypto' => $featuredCrypto,
            'trendingCryptos' => $trendingCryptos,
            'topGainers' => $topGainers,
            'topLosers' => $topLosers,
            'topByMarketCap' => $topByMarketCap,
        ]);
    }
}
