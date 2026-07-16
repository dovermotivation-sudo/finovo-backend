<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mt5Account extends Model
{
    protected $fillable = [
        'user_id',
        'login',
        'password',
        'server',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
