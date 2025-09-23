<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoalAssignment extends Model
{
    protected $fillable = [
        'goal_id', 'assigned_to', 'assigned_by', 'role',
    ];
}
