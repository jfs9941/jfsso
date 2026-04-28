<?php

namespace Module\Post\Query\Concerns;

use App\Providers\PostsHelperServiceProvider;
use App\User;
use Illuminate\Database\Eloquent\Builder;
trait FiltersGender
{
    protected function resolveGenderIds(?User $viewer): array
    {
        return [];
    }
    protected function applyGenderFilter(Builder $query, ?User $viewer): void
    {
    }
}
