<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralReward extends Model
{
    use HasFactory;

    protected $fillable = [
        'referral_id',
        'user_id',
        'reward_type',
        'reward_amount',
        'reward_description',
        'status',
        'credited_at',
    ];

    protected $casts = [
        'reward_amount' => 'decimal:2',
        'credited_at' => 'datetime',
    ];

    /**
     * Get the referral associated with this reward
     */
    public function referral()
    {
        return $this->belongsTo(Referral::class);
    }

    /**
     * Get the user who received the reward
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mark reward as credited
     */
    public function markAsCredited()
    {
        $this->update([
            'status' => 'credited',
            'credited_at' => now(),
        ]);
    }

    /**
     * Mark reward as cancelled
     */
    public function markAsCancelled()
    {
        $this->update([
            'status' => 'cancelled',
        ]);
    }

    /**
     * Scope to get pending rewards
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope to get credited rewards
     */
    public function scopeCredited($query)
    {
        return $query->where('status', 'credited');
    }
}
