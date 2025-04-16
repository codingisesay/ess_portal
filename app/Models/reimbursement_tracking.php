<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class reimbursement_tracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date', 'end_date', 'description', 'status', 'user_id', 'token_number'
    ];

    // Automatically generate a token before creating
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->token_number = self::generateUniqueToken();
        });
    }

    // Method to ensure the token is unique
    private static function generateUniqueToken()
    {
        do {
            $token = strtoupper(Str::random(10)); // e.g., "AB12CD34EF"
        } while (self::where('token_number', $token)->exists());

        return "#RM-".$token;
    }
}
