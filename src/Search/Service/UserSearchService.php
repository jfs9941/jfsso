<?php

namespace Module\Search\Service;

use App\User;
use Illuminate\Pagination\LengthAwarePaginator;
class UserSearchService
{
    public function search(string $query, int $authUserId, int $page = 1, int $perPage = 5): LengthAwarePaginator
    {
        throw new \RuntimeException();
    }
}
