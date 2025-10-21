<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cryptocurrency_id',
        'amount',
        'average_buy_price',
        'total_invested',
        'current_value',
        'profit_loss',
        'profit_loss_percent',
    ];

    protected $casts = [
        'amount' => 'decimal:8',
        'average_buy_price' => 'decimal:8',
        'total_invested' => 'decimal:8',
        'current_value' => 'decimal:8',
        'profit_loss' => 'decimal:8',
        'profit_loss_percent' => 'decimal:4',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cryptocurrency()
    {
        return $this->belongsTo(Cryptocurrency::class);
    }

    public function updateCurrentValue()
    {
        $this->current_value = $this->amount * $this->cryptocurrency->current_price;
        $this->profit_loss = $this->current_value - $this->total_invested;
        $this->profit_loss_percent = $this->total_invested > 0 
            ? ($this->profit_loss / $this->total_invested) * 100 
            : 0;
        $this->save();
    }

    public function getFormattedAmountAttribute()
    {
        return number_format($this->amount, 8);
    }

    public function getProfitLossClassAttribute()
    {
        return $this->profit_loss >= 0 ? 'text-green-500' : 'text-red-500';
    }
}