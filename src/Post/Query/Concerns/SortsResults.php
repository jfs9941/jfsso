<?php

namespace Module\Post\Query\Concerns;

use Illuminate\Database\Eloquent\Builder;
trait SortsResults
{
    protected function applyOrdering(Builder $query, ?string $sortOrder, ?string $sortBy = null): void
    {
    }
}
