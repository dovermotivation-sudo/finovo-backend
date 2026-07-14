<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    protected $fillable = [
        'referrer_id',
        'referred_user_id',
        'referral_code',
        'status',
        'referred_at',
        'activated_at',
        'rewarded_at',
    ];

    protected $casts = [
        'referred_at' => 'datetime',
        'activated_at' => 'datetime',
        'rewarded_at' => 'datetime',
    ];

    /**
     * Get the user who made the referral (referrer)
     */
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    /**
     * Get the user who was referred
     */
    public function referredUser()
    {
        return $this->belongsTo(User::class, 'referred_user_id');
    }

    /**
     * Get the rewards associated with this referral
     */
    public function rewards()
    {
        return $this->hasMany(ReferralReward::class);
    }

    /**
     * Mark referral as active
     */
    public function markAsActive()
    {
        $this->update([
            'status' => 'active',
            'activated_at' => now(),
        ]);
    }

    /**
     * Mark referral as rewarded
     */
    public function markAsRewarded()
    {
        $this->update([
            'status' => 'rewarded',
            'rewarded_at' => now(),
        ]);
    }

    /**
     * Scope to get pending referrals
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope to get active referrals
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to get rewarded referrals
     */
    public function scopeRewarded($query)
    {
        return $query->where('status', 'rewarded');
    }
}
