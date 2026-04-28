<?php

namespace Module\Post\Controller;

use App\Http\Controllers\Controller;
use App\Model\Post;
use App\Model\UserBookmark;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Module\Post\DTO\PostQueryParams;
use Module\Post\Resource\PaginationResource;
use Module\Post\Resource\PostResource;
use Module\Post\Service\PostQueryService;
class ApiBookmarkController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        throw new \RuntimeException();
    }
    public function store(string $postId): JsonResponse
    {
        throw new \RuntimeException();
    }
    public function destroy(string $postId): JsonResponse
    {
        throw new \RuntimeException();
    }
}
