<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cryptocurrency_id',
        'type',
        'amount',
        'price',
        'total',
        'fee',
        'transaction_hash',
        'status',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:8',
        'price' => 'decimal:8',
        'total' => 'decimal:8',
        'fee' => 'decimal:8',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cryptocurrency()
    {
        return $this->belongsTo(Cryptocurrency::class);
    }

    public function getTypeClassAttribute()
    {
        return $this->type === 'buy' ? 'text-green-500' : 'text-red-500';
    }

    public function getStatusClassAttribute()
    {
        return match($this->status) {
            'completed' => 'text-green-500',
            'pending' => 'text-yellow-500',
            'failed' => 'text-red-500',
            default => 'text-gray-500'
        };
    }
}