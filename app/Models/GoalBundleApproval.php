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

    // Relationship to fetch goals in this bundle
    public function items()
    {
        return $this->hasMany(GoalBundleItem::class, 'bundle_id');
    }

    // Relationship to fetch the user who requested this bundle
    public function requestedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'requested_by');
    }
}
