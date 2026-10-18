<?php

namespace App\Services\Statistics;

use Illuminate\Support\Facades\Schema;

class ModelRegistry
{
    /**
     * List of models available for Statistics Builder.
     */
    protected static array $models = [

        \App\Models\PatientArtclinic::class => [
            'label' => 'ART Clinic',
            'exclude_fields' => [
                'id',
                'created_at',
                'updated_at',
                'deleted_at',
            ],
            'relations' => [
                'reporting',
            ],
        ],

        \App\Models\PatientArtbank::class => [
            'label' => 'ART Bank',
            'exclude_fields' => [
                'id',
                'created_at',
                'updated_at',
                'deleted_at',
            ],
            'relations' => [
                'reporting',
            ],
        ],

        \App\Models\PatientSurrogacyClinic::class => [
            'label' => 'Surrogacy Clinic',
            'exclude_fields' => [
                'id',
                'created_at',
                'updated_at',
                'deleted_at',
            ],
            'relations' => [
                'reporting',
            ],
        ],

    ];

    /**
     * Return all registered models.
     */
    public static function all(): array
    {
        return self::$models;
    }

    /**
     * Get configuration for a model.
     */
    public static function get(string $model): ?array
    {
        return self::$models[$model] ?? null;
    }

    /**
     * Check whether model is registered.
     */
    public static function hasModel(string $model): bool
    {
        return isset(self::$models[$model]);
    }

    /**
     * Model label.
     */
    public static function label(string $model): ?string
    {
        return self::$models[$model]['label'] ?? null;
    }

    /**
     * Allowed relations.
     */
    public static function relations(string $model): array
    {
        return self::$models[$model]['relations'] ?? [];
    }

    /**
     * Model fields.
     */
    public static function fields(string $model): array
    {
        if (! self::hasModel($model)) {
            return [];
        }

        $instance = new $model();

        $columns = Schema::connection($instance->getConnectionName())
            ->getColumnListing($instance->getTable());

        return array_values(array_diff(
            $columns,
            self::$models[$model]['exclude_fields'] ?? []
        ));
    }

    /**
     * Relation fields.
     */
    public static function relationFields(string $model, string $relation): array
    {
        if (! self::hasRelation($model, $relation)) {
            return [];
        }

        $instance = new $model();

        $related = $instance->{$relation}()->getRelated();

        return Schema::connection($related->getConnectionName())
            ->getColumnListing($related->getTable());
    }

    /**
     * Validate field.
     */
    public static function hasField(string $model, string $field): bool
    {
        return in_array($field, self::fields($model));
    }

    /**
     * Validate relation.
     */
    public static function hasRelation(string $model, string $relation): bool
    {
        return in_array($relation, self::relations($model));
    }

    /**
     * Dropdown for UI.
     */
    public static function dropdown(): array
    {
        $data = [];

        foreach (self::$models as $class => $config) {
            $data[] = [
                'value' => $class,
                'label' => $config['label'],
            ];
        }

        return $data;
    }
    /**
     * Check whether a relation contains the given field.
     */
    public static function hasRelationField(
        string $model,
        string $relation,
        string $field
    ): bool {

        return in_array(
            $field,
            self::relationFields($model, $relation)
        );
    }
}