<?php

namespace App\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait Sortable
{
    /**
     * @var list<string>
     */
    protected array $allowedSortDirections = ['asc', 'desc'];

    /**
     * @param  array<int|string, string|callable(Builder, string): mixed>  $sortFields
     */
    public function scopeSort(
        Builder $query,
        ?string $sortBy,
        ?string $sortDirection,
        array $sortFields,
        string $defaultSortBy = 'created_at',
        string $defaultSortDirection = 'desc',
    ): Builder {
        [$sortBy, $sortDirection] = $this->resolveSort($sortBy, $sortDirection, $sortFields, $defaultSortBy, $defaultSortDirection);
        $field = $sortFields[$sortBy] ?? $sortBy;

        if (! is_string($field) && is_callable($field)) {
            $field($query, $sortDirection);

            return $query;
        }

        return $query->orderBy($field, $sortDirection);
    }

    /**
     * @param  array<int|string, string|callable(Builder, string): mixed>  $sortFields
     * @return array{0: string, 1: string}
     */
    protected function resolveSort(
        ?string $sortBy,
        ?string $sortDirection,
        array $sortFields,
        string $defaultSortBy,
        string $defaultSortDirection,
    ): array {
        $sortBy = $sortBy ?: $defaultSortBy;
        $sortDirection = $sortDirection ?: $defaultSortDirection;

        if (! in_array($sortBy, $this->validSortKeys($sortFields), true)) {
            $sortBy = $defaultSortBy;
        }

        if (! in_array($sortDirection, $this->allowedSortDirections, true)) {
            $sortDirection = $defaultSortDirection;
        }

        return [$sortBy, $sortDirection];
    }

    /**
     * @param  array<int|string, string|callable(Builder, string): mixed>  $sortFields
     * @return list<string>
     */
    private function validSortKeys(array $sortFields): array
    {
        return collect($sortFields)
            ->map(fn (mixed $field, int|string $key): string => is_int($key) ? (string) $field : (string) $key)
            ->values()
            ->all();
    }
}
