<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title', 'description', 'priority', 'status',
        'created_by', 'assigned_to', 'start_date', 'end_date'
    ];
}
