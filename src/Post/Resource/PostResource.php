<?php

namespace Module\Post\Resource;

use App\Model\Post;
use App\Providers\ListsHelperServiceProvider;
use App\Providers\PostsHelperServiceProvider;
use App\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Module\Profile\Helpers\AttachmentHelper;
class PostResource
{
    public static function format(Post $post): array
    {
        return [];
    }
    public static function collection(LengthAwarePaginator $paginator): array
    {
        return [];
    }
}
