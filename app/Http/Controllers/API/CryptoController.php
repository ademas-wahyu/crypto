<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cryptocurrency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CryptoController extends Controller
{
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
            
        if (!$crypto) {
            return response()->json(['error' => 'Cryptocurrency not found'], 404);
        }
        
        // Simulasi perubahan harga real-time
        $change = (rand(-100, 100) / 10000) * $crypto->current_price;
        $newPrice = $crypto->current_price + $change;
        $changePercent = ($change / $crypto->current_price) * 100;
        
        return response()->json([
            'symbol' => $crypto->symbol,
            'price' => $newPrice,
            'change' => $change,
            'changePercent' => $changePercent,
            'timestamp' => now()->timestamp
        ]);
    }
    
    public function historical($symbol, $period = '7d')
    {
        $crypto = Cryptocurrency::where('symbol', strtoupper($symbol))
            ->where('is_active', true)
            ->firstOrFail();
            
        // Generate historical data simulasi
        $data = [];
        $basePrice = $crypto->current_price;
        $days = match($period) {
            '1d' => 1,
            '7d' => 7,
            '30d' => 30,
            '90d' => 90,
            '1y' => 365,
            default => 7
        };
        
        for ($i = $days; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $variation = (rand(-500, 500) / 10000) * $basePrice;
            $price = $basePrice + $variation;
            
            $data[] = [
                'timestamp' => $date->timestamp * 1000,
                'date' => $date->format('Y-m-d'),
                'price' => $price,
                'volume' => rand(1000000, 10000000)
            ];
        }
        
        return response()->json($data);
    }
    
    public function trending()
    {
        $cryptos = Cryptocurrency::where('is_active', true)
            ->where('volume_24h', '>', 0)
            ->orderBy('volume_24h', 'desc')
            ->take(10)
            ->get();
            
        return response()->json($cryptos);
    }
    
    public function gainers()
    {
        $cryptos = Cryptocurrency::where('is_active', true)
            ->where('change_percent_24h', '>', 0)
            ->orderBy('change_percent_24h', 'desc')
            ->take(10)
            ->get();
            
        return response()->json($cryptos);
    }
    
    public function losers()
    {
        $cryptos = Cryptocurrency::where('is_active', true)
            ->where('change_percent_24h', '<', 0)
            ->orderBy('change_percent_24h', 'asc')
            ->take(10)
            ->get();
            
        return response()->json($cryptos);
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
}