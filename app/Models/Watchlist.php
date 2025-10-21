<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Watchlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cryptocurrency_id',
        'target_price',
        'alert_type',
        'is_active',
    ];

    protected $casts = [
        'target_price' => 'decimal:8',
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cryptocurrency()
    {
        return $this->belongsTo(Cryptocurrency::class);
    }

    public function checkAlert()
    {
        if (!$this->is_active || !$this->target_price) {
            return false;
        }

        $currentPrice = $this->cryptocurrency->current_price;
        
        if ($this->alert_type === 'above' && $currentPrice >= $this->target_price) {
            return true;
        }
        
        if ($this->alert_type === 'below' && $currentPrice <= $this->target_price) {
            return true;
        }
        
        return false;
    }
}