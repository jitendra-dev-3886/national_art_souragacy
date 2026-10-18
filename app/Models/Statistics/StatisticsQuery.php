<?php

namespace App\Models\Statistics;

class StatisticsQuery extends BaseStatisticsModel
{
    protected $table = 'statistics_queries';

    protected $casts = [
        'is_distinct' => 'boolean',
    ];

    public function metric()
    {
        return $this->belongsTo(
            StatisticsMetric::class,
            'metric_id'
        );
    }

    public function operations()
    {
        return $this->hasMany(
            StatisticsOperation::class,
            'query_id'
        )->orderBy('sequence');
    }
}