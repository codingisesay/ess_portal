<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoalBundleApproval extends Model
{
    use HasFactory;

    protected $table = 'goal_bundle_approvals';

    protected $fillable = [
        'requested_by',
        'reporting_manager',
        'status',
        'remarks',
    ];

    public function items()
    {
        return $this->hasMany(GoalBundleItem::class, 'bundle_id');
    }
}
