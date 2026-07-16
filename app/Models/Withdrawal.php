<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'fee',
        'network',
        'wallet_address',
        'status',
        'transaction_id',
        'remarks',
        'approved_at',
        'rejected_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'fee' => 'decimal:2',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime'
    ];

    /**
     * Get the user that owns the withdrawal request.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
