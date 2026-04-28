<?php

namespace Module\Post\Resource;

use App\Model\PostComment;
use Illuminate\Support\Facades\Auth;
class CommentResource
{
    public static function format(PostComment $comment): array
    {
        return [];
    }
    private static function isPostOwner(PostComment $comment, int $userId): bool
    {
        return false;
    }
}
