<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrPolicyCategory extends Model
{
    use HasFactory;

    protected $table = 'hr_policy_categories';

    protected $fillable = [
        'name',
        'organisation_id',
    ];
}
