<?php

namespace Module\Post\Resource;

use App\User;
use App\Providers\GenericHelperServiceProvider;
use Module\MediaResolver\ImagePathSizeResolver;
class UserResource
{
    public static function format(User $user): array
    {
        return [];
    }
    public static function formatCompact(User $user): array
    {
        return [];
    }
}
