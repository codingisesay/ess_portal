<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InsightBundleApproval extends Model
{
    protected $table = 'insight_bundle_approvals';

    protected $fillable = [
        'requested_by',
        'reporting_manager',
        'status',
        'remarks',
    ];

    public function items()
    {
        return $this->hasMany(InsightBundleItem::class, 'bundle_id');
    }

    public function requestedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'requested_by');
    }
}
