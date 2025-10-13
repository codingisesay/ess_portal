<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InsightBundleItem extends Model
{
    protected $table = 'insight_bundle_items';

    protected $fillable = [
        'bundle_id',
        'insight_id',
    ];

    public function bundle()
    {
        return $this->belongsTo(InsightBundleApproval::class, 'bundle_id');
    }

    public function insight()
    {
        return $this->belongsTo(\App\Models\Insight::class, 'insight_id');
    }
}
