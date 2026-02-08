<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'certificate_type', 'request_for', 'status',
        'first_name', 'last_name', 'contact_number', 'email', 'current_address',
        'date_of_birth', 'purpose', 'owner_first_name', 'owner_last_name',
        'owner_date_of_birth', 'relationship', 'third_party_reason', 'id_photo_path',
        'id_front_photo', 'id_back_photo', 'additional_photos',
        'admin_remarks', 'certificate_file_path', 'payment_status', 'payment_amount',
        'payment_reference', 'paymongo_checkout_id', 'paymongo_payment_intent_id', 
        'payment_paid_at', 'reviewed_at', 'approved_at', 'completed_at', 'processed_by',
        'father_first_name', 'father_last_name', 'mother_first_name', 'mother_last_name',
        'registered_parish'
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
        'approved_at' => 'datetime',
        'completed_at' => 'datetime',
        'payment_paid_at' => 'datetime',
        'additional_photos' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    // Status helper methods
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isProcessing()
    {
        return $this->status === 'processing';
    }

    public function isReady()
    {
        return $this->status === 'ready';
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function isDeclined()
    {
        return $this->status === 'declined';
    }
}
