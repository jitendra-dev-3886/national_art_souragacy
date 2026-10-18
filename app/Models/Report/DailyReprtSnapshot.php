<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyReprtSnapshot extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'report_daily_metrics';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'report_date',
        'field_code',
        'field_value',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'report_date' => 'date',
        'field_value' => 'integer',
    ];
}