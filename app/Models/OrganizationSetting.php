<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationSetting extends Model
{
    use HasFactory;

    protected $fillable = [
            'name',
            'year',
            'cycle_type',
            'cycle_period',
            'start_date',
            'end_date',
            'process_start_date',
            'process_end_date',
            'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function goals()
    {
        return $this->hasMany(Goal::class, 'org_setting_id');
    }
}
