<?php

namespace Module\MediaGallery\Service;

use App\Model\Media;
use Aws\CloudFront\CloudFrontClient;
use Aws\CloudFront\UrlSigner;
use Illuminate\Support\Facades\Storage;
use Module\Upload\Enum\FileDriver;
use Module\Upload\Enum\MediaTypeEnum;
final class PathResolver
{
    public function __construct(private readonly bool $cdnEnabled = true, private readonly string $s3Url, public readonly string $cdnUrl, private readonly string $keyId, private readonly string $keyPath)
    {
    }
    public function resolvePath(Media|string $media, $driver = FileDriver::S3): string
    {
        return '';
    }
    public function resolveThumbnail(Media $media): string
    {
        return '';
    }
    private function url(string $path, $driver): string
    {
        return '';
    }
    private function generatePresignUrl(string $path): string
    {
        return '';
    }
    public function resolvePathForHlsVideo(Media $video, bool $strict = false): array
    {
        return [];
    }
    public function resolvePathForHlsVideos(): array
    {
        return [];
    }
}
