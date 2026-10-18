<?php

namespace App\Models\Statistics;

use Illuminate\Database\Eloquent\Model;

abstract class BaseStatisticsModel extends Model
{
    /**
     * Statistics database connection.
     */
    protected $connection = 'statistics';

    /**
     * Mass assignment protection.
     */
    protected $guarded = [];
}