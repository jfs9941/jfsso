<?php

namespace Module\Search\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Module\Search\Resource\SearchUserResource;
use Module\Search\Service\UserSearchService;
class ApiSearchUserController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        throw new \RuntimeException();
    }
}
