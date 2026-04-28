<?php

namespace Module\Message\Http\Controller;

use App\Http\Controllers\Controller;
use App\Providers\GenericHelperServiceProvider;
use App\Providers\MessengerProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
class ApiMessageController extends Controller
{
    public function send(Request $request): JsonResponse
    {
        throw new \RuntimeException();
    }
}
