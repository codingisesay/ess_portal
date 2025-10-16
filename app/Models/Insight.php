<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insight extends Model
{
    protected $fillable = [
        'goal_id', 'user_id', 'description'
    ];

    // ✅ Add this relationship
    public function goal()
    {
        return $this->belongsTo(\App\Models\Goal::class, 'goal_id');
    }
}
