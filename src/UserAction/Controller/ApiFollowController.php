<?php

namespace Module\UserAction\Controller;

use App\Http\Controllers\Controller;
use App\Providers\ListsHelperServiceProvider;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
class ApiFollowController extends Controller
{
    public function follow(string $userId): JsonResponse
    {
        throw new \RuntimeException();
    }
    public function unfollow(string $userId): JsonResponse
    {
        throw new \RuntimeException();
    }
}
