<?php

namespace Module\Post\Service;

use Illuminate\Pagination\LengthAwarePaginator;
use Module\Post\DTO\PostQueryParams;
use Module\Post\Query\BookmarksPostsQuery;
use Module\Post\Query\FeedPostsQuery;
use Module\Post\Query\ProfilePostsQuery;
use Module\Post\Query\SearchPostsQuery;
class PostQueryService
{
    public function feedPosts(PostQueryParams $params): LengthAwarePaginator
    {
        throw new \RuntimeException();
    }
    public function profilePosts(PostQueryParams $params): LengthAwarePaginator
    {
        throw new \RuntimeException();
    }
    public function bookmarkedPosts(PostQueryParams $params): LengthAwarePaginator
    {
        throw new \RuntimeException();
    }
    public function searchPosts(PostQueryParams $params): LengthAwarePaginator
    {
        throw new \RuntimeException();
    }
}
