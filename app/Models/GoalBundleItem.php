<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoalBundleItem extends Model
{
    use HasFactory;

    protected $table = 'goal_bundle_items';

    protected $fillable = [
        'bundle_id',
        'goal_id',
    ];

    public function bundle()
    {
        return $this->belongsTo(GoalBundleApproval::class, 'bundle_id');
    }

    public function goal()
    {
        return $this->belongsTo(Goal::class, 'goal_id');
    }
}
