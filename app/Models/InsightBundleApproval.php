<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InsightBundleApproval extends Model
{
    protected $table = 'insight_bundle_approvals';

    protected $fillable = [
        'requested_by',
        'reporting_manager',
        'status_level1',   // Level 1 approval status
        'status_level2',   // Level 2 approval status
        'level1_approver', // User ID who approved Level 1
        'level2_approver', // User ID who approved Level 2
        'rating_level1',   // Rating by Level 1 approver
        'rating_level2',   // Rating by Level 2 approver
        'remarks',         // Remarks (optional)
    ];

    // Relationship: bundle items
    public function items()
    {
        return $this->hasMany(InsightBundleItem::class, 'bundle_id');
    }

    // Relationship: user who requested the bundle
    public function requestedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'requested_by');
    }

    // Relationship: reporting manager
    public function reportingManager()
    {
        return $this->belongsTo(\App\Models\User::class, 'reporting_manager');
    }
}
