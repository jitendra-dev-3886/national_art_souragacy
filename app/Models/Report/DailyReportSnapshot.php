<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Model;

class DailyReportSnapshot extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'daily_report_snapshots';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'report_date',
        'report_data',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'report_date' => 'date',
        // This automatically converts the DB JSON string into a PHP array
        'report_data' => 'array', 
    ];
}