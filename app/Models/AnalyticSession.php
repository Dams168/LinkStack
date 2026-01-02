<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalyticSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'visitor_uuid',
        'started_at',
        'last_activity_at',
        'page_count',
    ];

    public $timestamps = false;

    public function pageViews()
    {
        return $this->hasMany(AnalyticPageView::class, 'analytic_session_id');
    }
}
