<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
 protected $fillable = [
    'name',
    'email',
    'password',
    'dob',
    'nic_number',
    'role',
    'phone',
    'must_change_password',
    'temp_password_code',
];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'must_change_password' => 'boolean',
    ];
    public function hasRole($role)
    {
        $roleStr = is_string($role) ? strtolower(trim($role)) : '';
        $userRoleStr = strtolower(trim((string) ($this->role ?? '')));

        if ($userRoleStr !== '' && $userRoleStr === $roleStr) {
            return true;
        }

        if ($this->roles && $this->roles->contains(function ($r) use ($roleStr) {
            return strtolower(trim($r->name)) === $roleStr;
        })) {
            return true;
        }

        return false;
    }

    public function isSuperAdmin(): bool
    {
        return strtolower(trim((string) ($this->role ?? ''))) === 'super admin' || $this->hasRole('Super Admin');
    }

}
