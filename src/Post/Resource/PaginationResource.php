<?php

namespace Module\Post\Resource;

use Illuminate\Pagination\LengthAwarePaginator;
class PaginationResource
{
    public static function format(LengthAwarePaginator $paginator, ?string $basePath = null): array
    {
        return [];
    }
}
