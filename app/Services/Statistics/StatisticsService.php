<?php

namespace App\Services\Statistics;

use Illuminate\Support\Facades\Config;
use InvalidArgumentException;

class StatisticsService
{
    protected StatisticQuery $query;
    protected FormulaEngine $formula;

    public function __construct(
        StatisticQuery $query,
        FormulaEngine $formula
    ) {
        $this->query = $query;
        $this->formula = $formula;
    }

    /**
     * Calculate a statistic.
     *
     * Accepts:
     * 1. Array definition
     * 2. Config key
     */
    public function calculate(string|array $definition): array
    {
        if (is_string($definition)) {

            $definition = Config::get("dashboard_statistics.{$definition}");

            if (!$definition) {
                throw new InvalidArgumentException(
                    "Statistic definition not found."
                );
            }
        }

        return $this->execute($definition);
    }

    /**
     * Execute a statistic definition.
     */
    protected function execute(array $definition): array
    {
        if (!isset($definition['queries'])) {
            throw new InvalidArgumentException(
                "Queries are required."
            );
        }

        $queryResults = [];

        foreach ($definition['queries'] as $name => $query) {

            $queryResults[$name] = $this->query->execute($query);

        }

        if (empty($definition['formula'])) {

            return [
                'value' => array_sum($queryResults),
                'queries' => $queryResults
            ];
        }

        return [
            'value' => $this->formula->evaluate(
                $definition['formula'],
                $queryResults
            ),
            'formula' => $definition['formula'],
            'queries' => $queryResults
        ];
    }

    /**
     * Execute a single query.
     */
    public function query(array $query): mixed
    {
        return $this->query->execute($query);
    }

    /**
     * Execute multiple independent queries.
     */
    public function queries(array $queries): array
    {
        $results = [];

        foreach ($queries as $name => $query) {

            $results[$name] = $this->query->execute($query);

        }

        return $results;
    }

    /**
     * Evaluate a formula directly.
     */
    public function formula(
        string $formula,
        array $values
    ): mixed {
        return $this->formula->evaluate(
            $formula,
            $values
        );
    }

    /**
     * Return raw query builder.
     */
    public function builder(array $query)
    {
        return $this->query->builder($query);
    }
}