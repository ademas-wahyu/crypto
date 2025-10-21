<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cryptocurrency extends Model
{
    use HasFactory;

    protected $fillable = [
        'symbol',
        'name',
        'logo',
        'current_price',
        'market_cap',
        'volume_24h',
        'change_24h',
        'change_percent_24h',
        'historical_data',
        'is_active',
        'rank',
    ];

    protected $casts = [
        'current_price' => 'decimal:8',
        'market_cap' => 'decimal:2',
        'volume_24h' => 'decimal:2',
        'change_24h' => 'decimal:4',
        'change_percent_24h' => 'decimal:4',
        'historical_data' => 'array',
        'is_active' => 'boolean',
    ];

    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function watchlists()
    {
        return $this->hasMany(Watchlist::class);
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->current_price, 8);
    }

    public function getFormattedMarketCapAttribute()
    {
        if ($this->market_cap >= 1000000000) {
            return '$' . number_format($this->market_cap / 1000000000, 2) . 'B';
        } elseif ($this->market_cap >= 1000000) {
            return '$' . number_format($this->market_cap / 1000000, 2) . 'M';
        }
        return '$' . number_format($this->market_cap, 2);
    }

    public function getPriceChangeClassAttribute()
    {
        return $this->change_24h >= 0 ? 'text-green-500' : 'text-red-500';
    }
}