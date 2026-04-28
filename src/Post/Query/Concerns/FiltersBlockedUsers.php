<?php

namespace Module\Post\Query\Concerns;

use App\Model\UserList;
use App\Providers\ListsHelperServiceProvider;
use App\User;
use Illuminate\Database\Eloquent\Builder;
trait FiltersBlockedUsers
{
    protected function excludeBlockedUsers(Builder $query, ?User $viewer): void
    {
    }
}
