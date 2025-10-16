<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bank extends Model
{
    protected $table = 'banks';
    protected $fillable = ['name', 'status'];
    public $timestamps = true;
}