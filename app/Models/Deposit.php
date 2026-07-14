<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'network',
        'transaction_id',
        'screenshot_path',
        'status',
        'remarks',
        'approved_at',
        'rejected_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime'
    ];

    /**
     * Get the user that owns the deposit request.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
