<?php

namespace Module\Search\Resource;

use App\User;
use Module\MediaResolver\ImagePathSizeResolver;
class SearchUserResource
{
    public static function format(User $user): array
    {
        return [];
    }
}
