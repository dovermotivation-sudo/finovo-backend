<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Otp extends Model
{
    protected $fillable = [
        'user_id',
        'otp',
        'expires_at',
    ];

    protected $hidden = [
        'otp',
    ];
    
    protected $appends = [
        'plain_otp',
    ];
    
    protected $casts = [
        'expires_at' => 'datetime',
    ];
    
    public function getPlainOtpAttribute()
    {
        return $this->otp; // This will be decrypted by the mutator
    }
    
    public function setOtpAttribute($value)
    {
        $this->attributes['otp'] = bcrypt($value);
    }
    
    public function validateOtp($otp): bool
    {
        return password_verify($otp, $this->otp);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }
}
