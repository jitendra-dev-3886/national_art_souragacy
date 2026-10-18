<?php

namespace App\Models\Statistics;

class StatisticsCache extends BaseStatisticsModel
{
    protected $table = 'statistics_cache';

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function metric()
    {
        return $this->belongsTo(
            StatisticsMetric::class,
            'metric_id'
        );
    }
}