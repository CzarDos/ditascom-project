<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'parish_name',
        'parish_address',
        'parish_logo',
        'password',
        'role',
    ];

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

    public function isAdministrator()
    {
        return $this->role === 'administrator';
    }

    public function isSubAdministrator()
    {
        return $this->role === 'sub-administrator';
    }

    public function isParishioner()
    {
        return $this->role === 'parishioner';
    }

    public function getDashboardRoute()
    {
        return match($this->role) {
            'administrator' => 'admin.dashboard',
            'sub-administrator' => 'subadmin.dashboard',
            'parishioner' => 'parishioner.dashboard',
            default => 'login',
        };
    }
}
