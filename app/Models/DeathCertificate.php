<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeathCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'cert_id',
        'full_name',
        'date_of_death',
        'place_of_cemetery',
        'fathers_full_name',
        'mothers_full_name',
        'residents_address',
        'remarks',
        'parish',
        'parish_address',
        'priest_name',
        'status',
        'subadmin_id'
    ];

    protected $casts = [
        'date_of_death' => 'date'
    ];

    public function subadmin()
    {
        return $this->belongsTo(User::class, 'subadmin_id');
    }
}
