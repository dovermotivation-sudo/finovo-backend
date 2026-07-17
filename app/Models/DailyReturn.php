<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyReturn extends Model
{
    protected $fillable = [
        'user_id',
        'return_date',
        'return_percentage',
        'return_amount',
        'notes',
    ];

    protected $casts = [
        'return_date'       => 'date',
        'return_percentage' => 'decimal:4',
        'return_amount'     => 'decimal:2',
    ];

    /**
     * Get the user that owns the daily return record.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
