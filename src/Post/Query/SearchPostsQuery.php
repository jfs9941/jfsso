<?php

namespace Module\Post\Query;

use Module\Post\Model\Post;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Module\Post\DTO\PostQueryParams;
use Module\Post\Query\Concerns\FiltersApprovedPosts;
use Module\Post\Query\Concerns\FiltersBlockedUsers;
use Module\Post\Query\Concerns\FiltersGender;
use Module\Post\Query\Concerns\FiltersMediaType;
use Module\Post\Query\Concerns\FiltersScheduledPosts;
use Module\Post\Query\Concerns\Paginates;
use Module\Post\Query\Concerns\ResolvesUserAccess;
use Module\Post\Query\Concerns\SortsResults;
class SearchPostsQuery
{
    use FiltersApprovedPosts;
    use FiltersBlockedUsers;
    use FiltersScheduledPosts;
    use FiltersMediaType;
    use FiltersGender;
    use ResolvesUserAccess;
    use SortsResults;
    use Paginates;
    public function __construct(private PostQueryParams $params)
    {
    }
    public function get(): LengthAwarePaginator
    {
        throw new \RuntimeException();
    }
}
