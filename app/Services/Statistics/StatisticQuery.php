<?php

namespace App\Services\Statistics;

use Illuminate\Database\Eloquent\Builder;
use InvalidArgumentException;

class StatisticQuery
{
    /**
     * Query definition from statistics_queries table.
     *
     * @var \App\Models\Statistics\StatisticsQuery
     */
    protected $definition;

    /**
     * Eloquent Builder instance.
     */
    protected Builder $builder;

    /**
     * Constructor.
     */
    public function __construct($definition)
    {
        $this->definition = $definition;
    }

    /**
     * Execute the configured query.
     *
     * @return mixed
     *
     * @throws \Throwable
     */
    public function execute()
    {
        $modelClass = $this->definition->model_class;

        if (! ModelRegistry::hasModel($modelClass)) {
            throw new InvalidArgumentException(
                "Model [{$modelClass}] is not registered."
            );
        }

        $this->builder = $modelClass::query();

        /*
        |--------------------------------------------------------------------------
        | Apply all operations
        |--------------------------------------------------------------------------
        */

        foreach ($this->definition->operations as $operation) {

            $this->applyOperation($operation);

        }

        /*
        |--------------------------------------------------------------------------
        | Execute Aggregate
        |--------------------------------------------------------------------------
        */

        return $this->executeAggregate();
    }

    /**
     * Execute aggregate function.
     *
     * @return mixed
     */
    protected function executeAggregate()
    {
        if ($this->definition->is_distinct) {

            $this->builder->distinct();

        }

        $function = strtolower($this->definition->aggregate_function);

        $column = $this->definition->aggregate_column;

        switch ($function) {

            case 'count':

                return $column === '*'
                    ? $this->builder->count()
                    : $this->builder->count($column);

            case 'sum':

                return $this->builder->sum($column);

            case 'avg':

                return $this->builder->avg($column);

            case 'min':

                return $this->builder->min($column);

            case 'max':

                return $this->builder->max($column);

            case 'exists':

                return $this->builder->exists();

            case 'first':

                return $this->builder->first();

            case 'value':

                return $this->builder->value($column);

            case 'pluck':

                return $this->builder->pluck($column);

            case 'get':

                return $this->builder->get();

            default:

                throw new InvalidArgumentException(
                    "Unsupported aggregate function [{$function}]"
                );

        }
    }
    /**
     * Apply a single operation to the query.
     *
     * @param  \App\Models\Statistics\StatisticsOperation  $operation
     * @return void
     */
    protected function applyOperation($operation): void
    {
        $this->validateOperation($operation);
        switch ($operation->operation) {

            /*
            |--------------------------------------------------------------------------
            | WHERE
            |--------------------------------------------------------------------------
            */

            case 'where':

                $method = strtolower($operation->boolean_operator) === 'or'
                    ? 'orWhere'
                    : 'where';

                $this->builder->{$method}(
                    $operation->field_name,
                    $operation->operator,
                    $this->castValue($operation->value)
                );

                break;

            /*
            |--------------------------------------------------------------------------
            | WHERE IN
            |--------------------------------------------------------------------------
            */

            case 'whereIn':

                $method = strtolower($operation->boolean_operator) === 'or'
                    ? 'orWhereIn'
                    : 'whereIn';

                $this->builder->{$method}(
                    $operation->field_name,
                    $this->arrayValue($operation->value)
                );

                break;

            /*
            |--------------------------------------------------------------------------
            | WHERE NOT IN
            |--------------------------------------------------------------------------
            */

            case 'whereNotIn':

                $method = strtolower($operation->boolean_operator) === 'or'
                    ? 'orWhereNotIn'
                    : 'whereNotIn';

                $this->builder->{$method}(
                    $operation->field_name,
                    $this->arrayValue($operation->value)
                );

                break;

            /*
            |--------------------------------------------------------------------------
            | WHERE BETWEEN
            |--------------------------------------------------------------------------
            */

            case 'whereBetween':

                $this->builder->whereBetween(
                    $operation->field_name,
                    [
                        $this->castValue($operation->value),
                        $this->castValue($operation->second_value)
                    ]
                );

                break;

            /*
            |--------------------------------------------------------------------------
            | WHERE NULL
            |--------------------------------------------------------------------------
            */

            case 'whereNull':

                $this->builder->whereNull($operation->field_name);

                break;

            /*
            |--------------------------------------------------------------------------
            | WHERE NOT NULL
            |--------------------------------------------------------------------------
            */

            case 'whereNotNull':

                $this->builder->whereNotNull($operation->field_name);

                break;

            /*
            |--------------------------------------------------------------------------
            | WHERE DATE
            |--------------------------------------------------------------------------
            */

            case 'whereDate':

                $this->builder->whereDate(
                    $operation->field_name,
                    $operation->operator,
                    $operation->value
                );

                break;

            /*
            |--------------------------------------------------------------------------
            | WHERE MONTH
            |--------------------------------------------------------------------------
            */

            case 'whereMonth':

                $this->builder->whereMonth(
                    $operation->field_name,
                    $operation->operator,
                    $operation->value
                );

                break;

            /*
            |--------------------------------------------------------------------------
            | WHERE YEAR
            |--------------------------------------------------------------------------
            */

            case 'whereYear':

                $this->builder->whereYear(
                    $operation->field_name,
                    $operation->operator,
                    $operation->value
                );

                break;

            /*
            |--------------------------------------------------------------------------
            | WHERE HAS
            |--------------------------------------------------------------------------
            */

            case 'whereHas':

                $this->builder->whereHas(
                    $operation->relation_name,
                    function ($query) use ($operation) {

                        $query->where(
                            $operation->field_name,
                            $operation->operator,
                            $this->castValue($operation->value)
                        );

                    }
                );

                break;

            /*
            |--------------------------------------------------------------------------
            | GROUP BY
            |--------------------------------------------------------------------------
            */

            case 'groupBy':

                $this->builder->groupBy($operation->field_name);

                break;

            /*
            |--------------------------------------------------------------------------
            | HAVING
            |--------------------------------------------------------------------------
            */

            case 'having':

                $this->builder->having(
                    $operation->field_name,
                    $operation->operator,
                    $this->castValue($operation->value)
                );

                break;

            /*
            |--------------------------------------------------------------------------
            | ORDER BY
            |--------------------------------------------------------------------------
            */

            case 'orderBy':

                $this->builder->orderBy(
                    $operation->field_name,
                    strtolower($operation->direction) === 'desc'
                        ? 'desc'
                        : 'asc'
                );

                break;

            /*
            |--------------------------------------------------------------------------
            | SELECT
            |--------------------------------------------------------------------------
            */

            case 'select':

                $this->builder->select(
                    $this->arrayValue($operation->value)
                );

                break;

            /*
            |--------------------------------------------------------------------------
            | ADD SELECT
            |--------------------------------------------------------------------------
            */

            case 'addSelect':

                $this->builder->addSelect(
                    $this->arrayValue($operation->value)
                );

                break;

            /*
            |--------------------------------------------------------------------------
            | LIMIT
            |--------------------------------------------------------------------------
            */

            case 'limit':

                $this->builder->limit(
                    (int) $operation->value
                );

                break;

            /*
            |--------------------------------------------------------------------------
            | OFFSET
            |--------------------------------------------------------------------------
            */

            case 'offset':

                $this->builder->offset(
                    (int) $operation->value
                );

                break;

            default:

                throw new InvalidArgumentException(
                    "Unsupported operation [{$operation->operation}]"
                );
        }
    }
    /**
     * Validate an operation before applying it.
     *
     * @param  \App\Models\Statistics\StatisticsOperation  $operation
     * @return void
     */
    protected function validateOperation($operation): void
    {
        $model = $this->definition->model_class;

        switch ($operation->operation) {

            case 'where':
            case 'whereIn':
            case 'whereNotIn':
            case 'whereBetween':
            case 'whereNull':
            case 'whereNotNull':
            case 'whereDate':
            case 'whereMonth':
            case 'whereYear':
            case 'groupBy':
            case 'having':
            case 'orderBy':

                if (! ModelRegistry::hasField($model, $operation->field_name)) {
                    throw new InvalidArgumentException(
                        "Invalid field [{$operation->field_name}] for model [{$model}]"
                    );
                }

                break;

            case 'whereHas':

                if (! ModelRegistry::hasRelation($model, $operation->relation_name)) {
                    throw new InvalidArgumentException(
                        "Invalid relation [{$operation->relation_name}]"
                    );
                }

                if (! ModelRegistry::hasRelationField(
                    $model,
                    $operation->relation_name,
                    $operation->field_name
                )) {
                    throw new InvalidArgumentException(
                        "Invalid relation field [{$operation->field_name}]"
                    );
                }

                break;
        }
    }

    /**
     * Convert stored value into appropriate PHP type.
     */
    protected function castValue($value)
    {
        if ($value === null) {
            return null;
        }

        if (is_numeric($value)) {
            return strpos((string) $value, '.') !== false
                ? (float) $value
                : (int) $value;
        }

        $lower = strtolower((string) $value);

        if ($lower === 'true') {
            return true;
        }

        if ($lower === 'false') {
            return false;
        }

        if ($lower === 'null') {
            return null;
        }

        return $value;
    }

    /**
     * Convert comma separated values into array.
     */
    protected function arrayValue($value): array
    {
        if (is_array($value)) {
            return $value;
        }

        if ($value === null || trim($value) === '') {
            return [];
        }

        return array_map(
            fn ($item) => $this->castValue(trim($item)),
            explode(',', $value)
        );
    }

    /**
     * Return the underlying query builder.
     */
    public function builder(): Builder
    {
        return $this->builder;
    }
}