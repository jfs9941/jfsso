<?php

namespace Module\MediaResolver;

use App\Model\Attachment;
use Illuminate\Support\Facades\Redis;
class MediaResolver
{
    public const SET_KEY = 'image:needresize';
    public static function getMediaSizes(Attachment $attachment): array
    {
        return [];
    }
}
