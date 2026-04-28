<?php

namespace Module\Post\Query\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
trait Paginates
{
    protected function paginate(Builder $query, int $page = 1, ?int $perPage = null): LengthAwarePaginator
    {
        throw new \RuntimeException();
    }
}
