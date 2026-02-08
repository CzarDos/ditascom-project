<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaptismalCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'cert_id',
        'full_name',
        'date_of_birth',
        'place_of_birth',
        'mothers_full_name',
        'fathers_full_name',
        'date_of_baptism',
        'officiant',
        'sponsor1',
        'sponsor2',
        'parish',
        'parish_address',
        'status',
        'subadmin_id'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'date_of_baptism' => 'date'
    ];

    public function subadmin()
    {
        return $this->belongsTo(User::class, 'subadmin_id');
    }
}
