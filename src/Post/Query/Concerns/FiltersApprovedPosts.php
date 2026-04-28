<?php

namespace Module\Post\Query\Concerns;

use App\Model\Post;
use App\User;
use Illuminate\Database\Eloquent\Builder;
trait FiltersApprovedPosts
{
    protected function onlyApprovedPosts(Builder $query, ?User $viewer): void
    {
    }
}
