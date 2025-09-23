<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = [
        'org_setting_id',
        'title',
        'description',
        'priority',
        'status',
        'created_by',
    ];

    public function organizationSetting()
    {
        return $this->belongsTo(OrganizationSetting::class, 'org_setting_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignments()
    {
        return $this->hasMany(GoalAssignment::class, 'goal_id');
    }

    public function insights()
    {
        return $this->hasMany(Insight::class, 'goal_id');
    }
}
