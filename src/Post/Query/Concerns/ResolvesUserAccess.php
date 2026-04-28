<?php

namespace Module\Post\Query\Concerns;

use App\Providers\PostsHelperServiceProvider;
trait ResolvesUserAccess
{
    protected function getActiveSubscriptionIds(int $userId): array
    {
        return [];
    }
    protected function getFreeFollowingIds(int $userId): array
    {
        return [];
    }
    protected function getAccessibleUserIds(int $userId): array
    {
        return [];
    }
}
