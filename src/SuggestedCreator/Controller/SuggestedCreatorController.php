<?php

namespace Module\SuggestedCreator\Controller;

use App\Http\Controllers\Controller;
use App\Providers\MembersHelperServiceProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Module\MediaResolver\ImagePathSizeResolver;
class SuggestedCreatorController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        throw new \RuntimeException();
    }
}
