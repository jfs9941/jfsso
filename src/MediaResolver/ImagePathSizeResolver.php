<?php

namespace Module\MediaResolver;

use App\Providers\AttachmentServiceProvider;
use App\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
class ImagePathSizeResolver
{
    public static function getSizes(string $path): array
    {
        return [];
    }
    public static function getAvatar(User $user): ?array
    {
        return null;
    }
    public static function getCover(User $user): ?array
    {
        return null;
    }
    private static function fs(string $avatar, string $size): string
    {
        return '';
    }
    public static function resizeAvatar(User $user): void
    {
    }
    public static function resizeCover(User $user): void
    {
    }
}
