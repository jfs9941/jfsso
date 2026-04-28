<?php

namespace Module\Lists\Controller;

use App\Http\Controllers\Controller;
use App\Model\UserList;
use App\Model\UserListMember;
use App\Providers\ListsHelperServiceProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
class ApiListController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        throw new \RuntimeException();
    }
    public function toggle(Request $request, int $listId): JsonResponse
    {
        throw new \RuntimeException();
    }
}
