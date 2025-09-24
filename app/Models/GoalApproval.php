<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoalApproval extends Model
{
    use HasFactory;

    protected $fillable = [
        'goal_id',
        'requested_by',
        'reporting_manager',
        'status',
        'remarks'
    ];
}
