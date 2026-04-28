<?php

namespace Module\Post\Controller;

use App\Http\Controllers\Controller;
use App\Model\Post;
use App\Model\PostComment;
use App\Model\Reaction;
use App\Providers\NotificationServiceProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Module\Post\Resource\CommentResource;
class ApiCommentController extends Controller
{
    public function index(Request $request, string $postId): JsonResponse
    {
        throw new \RuntimeException();
    }
    public function store(Request $request, string $postId): JsonResponse
    {
        throw new \RuntimeException();
    }
    public function update(Request $request, string $commentId): JsonResponse
    {
        throw new \RuntimeException();
    }
    public function destroy(string $commentId): JsonResponse
    {
        throw new \RuntimeException();
    }
    public function toggleLike(string $commentId): JsonResponse
    {
        throw new \RuntimeException();
    }
}
