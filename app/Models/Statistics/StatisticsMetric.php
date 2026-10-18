<?php

namespace App\Models\Statistics;

class StatisticsMetric extends BaseStatisticsModel
{
    protected $table = 'statistics_metrics';

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function queries()
    {
        return $this->hasMany(
            StatisticsQuery::class,
            'metric_id'
        )->orderBy('execution_order');
    }

    public function cache()
    {
        return $this->hasMany(
            StatisticsCache::class,
            'metric_id'
        );
    }
}