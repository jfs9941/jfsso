<?php

namespace Module\MediaResolver\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
class MediaBrokenCollectionController
{
    public function collect(Request $request): JsonResponse
    {
        throw new \RuntimeException();
    }
}
