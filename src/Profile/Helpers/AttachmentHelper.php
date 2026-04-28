<?php

namespace Module\Profile\Helpers;

use App\Model\Attachment;
use App\Providers\AttachmentServiceProvider;
use Module\MediaGallery\Service\PathResolver;
use Module\MediaResolver\ImagePathSizeResolver;
use Module\MediaResolver\MediaResolver;
class AttachmentHelper
{
    public static function format(Attachment $attachment, bool $hasUnlocked = true): array
    {
        return [];
    }
    private static function getUrl($url)
    {
        return null;
    }
    private static function getThumbnail($thumbnail)
    {
        return null;
    }
    private static function getOriginalUrl($locked, $attachment)
    {
        return null;
    }
    private static function resolveVariants(Attachment $attachment, string $originalFilename): ?array
    {
        return null;
    }
    private static function getLink($path)
    {
        return null;
    }
    private static function getLink2($cdnUrl, $path, $filename, $extension, $size)
    {
        return null;
    }
    private static function getOriginal($cdnUrl, $originalFilename)
    {
        return null;
    }
}
