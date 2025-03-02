<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'login_time',
        'login_date',
        'logout_time',
    ];

    protected $dates = ['login_time', 'logout_time', 'created_at', 'updated_at'];
}
