<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        $portfolios = Portfolio::with('cryptocurrency')
            ->where('user_id', $user->id)
            ->get();
            
        // Update current values
        foreach ($portfolios as $portfolio) {
            $portfolio->updateCurrentValue();
        }
        
        $totalValue = $portfolios->sum('current_value');
        $totalInvested = $portfolios->sum('total_invested');
        $totalChange = $totalValue - $totalInvested;
        $totalChangePercent = $totalInvested > 0 ? ($totalChange / $totalInvested) * 100 : 0;
        
        return response()->json([
            'coins' => $portfolios,
            'totalValue' => $totalValue,
            'totalInvested' => $totalInvested,
            'totalChange' => $totalChange,
            'totalChangePercent' => $totalChangePercent,
            'balance' => $user->balance
        ]);
    }
    
    public function buy(Request $request)
    {
        $request->validate([
            'symbol' => 'required|string',
            'amount' => 'required|numeric|min:0.00000001',
            'price' => 'required|numeric|min:0'
        ]);
        
        $user = $request->user();
        $crypto = \App\Models\Cryptocurrency::where('symbol', strtoupper($request->symbol))
            ->where('is_active', true)
            ->firstOrFail();
            
        $total = $request->amount * $request->price;
        $fee = $total * 0.001; // 0.1% fee
        $totalWithFee = $total + $fee;
        
        if ($user->balance < $totalWithFee) {
            return response()->json([
                'error' => 'Saldo tidak mencukupi'
            ], 400);
        }
        
        DB::beginTransaction();
        
        try {
            // Update user balance
            $user->balance -= $totalWithFee;
            $user->save();
            
            // Create transaction
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'cryptocurrency_id' => $crypto->id,
                'type' => 'buy',
                'amount' => $request->amount,
                'price' => $request->price,
                'total' => $total,
                'fee' => $fee,
                'status' => 'completed'
            ]);
            
            // Update or create portfolio
            $portfolio = Portfolio::where('user_id', $user->id)
                ->where('cryptocurrency_id', $crypto->id)
                ->first();
                
            if ($portfolio) {
                // Update existing portfolio
                $oldAmount = $portfolio->amount;
                $oldTotalInvested = $portfolio->total_invested;
                
                $portfolio->amount += $request->amount;
                $portfolio->total_invested += $total;
                $portfolio->average_buy_price = $portfolio->total_invested / $portfolio->amount;
                $portfolio->updateCurrentValue();
            } else {
                // Create new portfolio
                $portfolio = Portfolio::create([
                    'user_id' => $user->id,
                    'cryptocurrency_id' => $crypto->id,
                    'amount' => $request->amount,
                    'average_buy_price' => $request->price,
                    'total_invested' => $total,
                    'current_value' => $total,
                    'profit_loss' => 0,
                    'profit_loss_percent' => 0
                ]);
            }
            
            DB::commit();
            
            return response()->json([
                'message' => 'Pembelian berhasil',
                'transaction' => $transaction,
                'portfolio' => $portfolio->load('cryptocurrency')
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => 'Terjadi kesalahan, silakan coba lagi'
            ], 500);
        }
    }
    
    public function sell(Request $request)
    {
        $request->validate([
            'symbol' => 'required|string',
            'amount' => 'required|numeric|min:0.00000001',
            'price' => 'required|numeric|min:0'
        ]);
        
        $user = $request->user();
        $crypto = \App\Models\Cryptocurrency::where('symbol', strtoupper($request->symbol))
            ->where('is_active', true)
            ->firstOrFail();
            
        $portfolio = Portfolio::where('user_id', $user->id)
            ->where('cryptocurrency_id', $crypto->id)
            ->first();
            
        if (!$portfolio || $portfolio->amount < $request->amount) {
            return response()->json([
                'error' => 'Saldo aset tidak mencukupi'
            ], 400);
        }
        
        $total = $request->amount * $request->price;
        $fee = $total * 0.001; // 0.1% fee
        $totalAfterFee = $total - $fee;
        
        DB::beginTransaction();
        
        try {
            // Update user balance
            $user->balance += $totalAfterFee;
            $user->save();
            
            // Create transaction
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'cryptocurrency_id' => $crypto->id,
                'type' => 'sell',
                'amount' => $request->amount,
                'price' => $request->price,
                'total' => $total,
                'fee' => $fee,
                'status' => 'completed'
            ]);
            
            // Update portfolio
            $portfolio->amount -= $request->amount;
            $portfolio->total_invested -= ($request->amount * $portfolio->average_buy_price);
            
            if ($portfolio->amount <= 0.00000001) {
                // Remove portfolio if amount is negligible
                $portfolio->delete();
            } else {
                $portfolio->updateCurrentValue();
            }
            
            DB::commit();
            
            return response()->json([
                'message' => 'Penjualan berhasil',
                'transaction' => $transaction,
                'total_received' => $totalAfterFee
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => 'Terjadi kesalahan, silakan coba lagi'
            ], 500);
        }
    }
}