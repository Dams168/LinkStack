<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalyticPageView extends Model
{
    use HasFactory;

    protected $fillable = [
        'analytic_session_id',
        'path',
        'created_at',
    ];

    public $timestamps = false;

    public function session()
    {
        return $this->belongsTo(AnalyticSession::class, 'analytic_session_id');
    }
}
