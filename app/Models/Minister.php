<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Minister extends Model
{
    protected $fillable = [
        'name',
        'title',
        'email',
        'phone',
        'parish_assignment',
        'address',
        'status'
    ];

    protected $casts = [
        'status' => 'string'
    ];

    public function getFullNameAttribute()
    {
        return $this->title ? "{$this->title} {$this->name}" : $this->name;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
