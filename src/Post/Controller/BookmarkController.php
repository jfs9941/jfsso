<?php

namespace Module\Post\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Module\Post\DTO\PostQueryParams;
use Module\Post\Service\PostQueryService;
use Module\Profile\Helpers\AttachmentHelper;
class BookmarkController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        throw new \RuntimeException();
    }
}
