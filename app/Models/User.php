<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'password',
        'role',
        'plan_id',
        'portfolio_value',
        'growth_rate',
        'total_returns',
        'email_verified_at',
        'profile_image',
        'referral_code',
        'referred_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'portfolio_value' => 'decimal:2',
        'growth_rate' => 'decimal:2',
        'total_returns' => 'decimal:2',
    ];

    /**
     * Get the OTP associated with the user.
     */
    public function otp()
    {
        return $this->hasOne(Otp::class);
    }

    /**
     * Check if user has verified their email.
     */
    public function hasVerifiedEmail()
    {
        return !is_null($this->email_verified_at);
    }

    /**
     * Mark the given user's email as verified.
     */
    public function markEmailAsVerified()
    {
        return $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * Send the OTP verification notification.
     */
    public function sendOtpNotification()
    {
        // Delete any existing OTPs for this user
        Otp::where('user_id', $this->id)->delete();
        
        // Generate a new OTP
        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Create the OTP record with the hashed version
        $otpRecord = Otp::create([
            'user_id' => $this->id,
            'otp' => $otp, // This will be hashed by the mutator
            'expires_at' => now()->addMinutes(30),
        ]);
        
        // Send the plain text OTP in the email
        $this->notify(new \App\Notifications\SendOtpNotification($otp));
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Get the user's KYC documents.
     */
    public function kycDocuments()
    {
        return $this->hasMany(KycDocument::class);
    }

    /**
     * Get the user's latest KYC document.
     */
    public function latestKyc()
    {
        return $this->hasOne(KycDocument::class)->latestOfMany();
    }

    /**
     * Check if user has verified KYC.
     */
    public function hasVerifiedKyc()
    {
        return $this->kycDocuments()->where('status', 'verified')->exists();
    }

    /**
     * Get the profile image URL or return default avatar
     */
    public function getProfileImageUrlAttribute()
    {
        // dd(asset('storage/' . $this->profile_image));
        // if ($this->profile_image && file_exists(public_path('storage/' . $this->profile_image))) {
        //     return asset('storage/' . $this->profile_image);
        // }
         if ($this->profile_image) {
            return asset('storage/' . $this->profile_image);
        }
        return null;
    }

    /**
     * Get user initials for avatar fallback
     */
    public function getInitialsAttribute()
    {
        $names = explode(' ', $this->name);
        $initials = '';
        foreach ($names as $name) {
            $initials .= strtoupper(substr($name, 0, 1));
        }
        return substr($initials, 0, 2);
    }

    /**
     * Generate unique referral code for user
     */
    public static function generateReferralCode()
    {
        do {
            $code = strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));
        } while (self::where('referral_code', $code)->exists());
        
        return $code;
    }

    /**
     * Get the user who referred this user
     */
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    /**
     * Get all users referred by this user
     */
    public function referrals()
    {
        return $this->hasMany(Referral::class, 'referrer_id');
    }

    /**
     * Get users this user has referred
     */
    public function referredUsers()
    {
        return $this->hasMany(User::class, 'referred_by');
    }

    /**
     * Get referral rewards for this user
     */
    public function referralRewards()
    {
        return $this->hasMany(ReferralReward::class);
    }

    /**
     * Get referral link
     */
    public function getReferralLinkAttribute()
    {
        return url('/register?ref=' . $this->referral_code);
    }

    /**
     * Get total referral count
     */
    public function getTotalReferralsAttribute()
    {
        return $this->referrals()->count();
    }

    /**
     * Get active referral count
     */
    public function getActiveReferralsAttribute()
    {
        return $this->referrals()->where('status', 'active')->count();
    }

    /**
     * Get total referral earnings
     */
    public function getTotalReferralEarningsAttribute()
    {
        return $this->referralRewards()->where('status', 'credited')->sum('reward_amount');
    }

}
