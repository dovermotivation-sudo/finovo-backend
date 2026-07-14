<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KycDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'document_type',
        'document_number',
        'document_front_path',
        'document_back_path',
        'selfie_path',
        'status',
        'remarks',
        'submitted_at',
        'verified_at',
        'verified_by',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    /**
     * Get the user that owns the KYC document.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin who verified the document.
     */
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Check if KYC is pending.
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if KYC is verified.
     */
    public function isVerified()
    {
        return $this->status === 'verified';
    }

    /**
     * Check if KYC is rejected.
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    /**
     * Get document type label.
     */
    public function getDocumentTypeLabel()
    {
        $labels = [
            'aadhaar' => 'Aadhaar Card',
            'pan' => 'PAN Card',
            'driving_license' => 'Driving License',
            'passport' => 'Passport',
            'voter_id' => 'Voter ID',
        ];

        return $labels[$this->document_type] ?? $this->document_type;
    }

    /**
     * Get status badge color.
     */
    public function getStatusColor()
    {
        return match($this->status) {
            'pending' => 'yellow',
            'verified' => 'green',
            'rejected' => 'red',
            default => 'gray',
        };
    }
}
