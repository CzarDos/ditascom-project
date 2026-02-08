<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfirmationCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'cert_id',
        'full_name',
        'date_of_birth',
        'place_of_birth',
        'fathers_full_name',
        'mothers_full_name',
        'date_of_baptism',
        'place_of_baptism',
        'date_of_confirmation',
        'place_of_confirmation',
        'sponsor1',
        'sponsor2',
        'remarks',
        'officiant',
        'parish',
        'parish_address',
        'status',
        'subadmin_id'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'date_of_baptism' => 'date',
        'date_of_confirmation' => 'date'
    ];

    public function subadmin()
    {
        return $this->belongsTo(User::class, 'subadmin_id');
    }
}
