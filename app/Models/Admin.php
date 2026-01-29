<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admins';

    protected $fillable = [
        'name',
        'email',
        'contact',
        'password',
        'role',
        'status',
        'last_login_at'
    ];

    protected $hidden = [
        'password'
    ];

    // Cast dates
    protected $casts = [
        'last_login_at' => 'datetime',
    ];

    // Always hash password automatically
    public function setPasswordAttribute($value)
    {
        if ($value !== null) {
            $this->attributes['password'] = bcrypt($value);
        }
    }

    // Helper: check active
    public function isActive()
    {
        return $this->status == 1;
    }

    // Helper: check role
    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }
}
