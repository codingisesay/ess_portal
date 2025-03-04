<?php
 
namespace App\Models;
 
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
 
class organisation extends Authenticatable
{
    // use HasFactory;
    use Notifiable;
 
    // protected $table = 'organisation'; // If your table name is different
 
    protected $fillable = [
        'name', 'email', 'password', // Add other fields as required
    ];
 
    protected $hidden = [
        'password',
    ];
 
    protected $casts = [
        'password' => 'hashed',
    ];
}
 
 