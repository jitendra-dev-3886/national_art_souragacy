<?php

namespace App\Models\Statistics;

class StatisticsOperation extends BaseStatisticsModel
{
    protected $table = 'statistics_operations';

    public function query()
    {
        return $this->belongsTo(
            StatisticsQuery::class,
            'query_id'
        );
    }
}