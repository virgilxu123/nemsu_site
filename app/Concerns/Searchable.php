<?php

namespace App\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    /**
     * Scope a query to search across multiple columns.
     *
     * @param  array<int, string>|string|null  $search
     * @param  array<int, string>  $columns
     */
    public function scopeSearch(Builder $query, array|string|null $search, array $columns, string $mode = 'contains'): Builder
    {
        $search = $this->normalizeSearch($search);

        if ($search === '' || $columns === []) {
            return $query;
        }

        $escapedSearch = str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $search);
        $pattern = $mode === 'prefix' ? "{$escapedSearch}%" : "%{$escapedSearch}%";

        return $query->where(fn (Builder $query) => $query->whereAny($columns, 'like', $pattern));
    }

    /**
     * @param  array<int, string>|string|null  $search
     */
    private function normalizeSearch(array|string|null $search): string
    {
        if (is_array($search)) {
            return trim(implode(' ', array_filter($search)));
        }

        return trim((string) $search);
    }
}
