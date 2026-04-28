<?php
declare(strict_types=1);

namespace Jfs\Uploader\Encoder;

use Jfs\Uploader\Core\FileInterface;
use Jfs\Uploader\Service\MediaPathResolver;
use Illuminate\Contracts\Filesystem\Filesystem;

final class HlsPathResolver
{
    public const HLS_PATH = 'v2/hls/';

    private $resolver;
    private $s3;

    public function __construct(MediaPathResolver $resolver, Filesystem $s3)
    {
        $this->resolver = $resolver;
        $this->s3 = $s3;
    }

    public function resolveHlsPath($video): string
    {
        return $this->resolver->resolveForPath(self::HLS_PATH.$video->getAttribute('id').'/');
    }

    public function resolveThumbnailPath($video): string
    {
        return $this->resolver->resolveForPath(self::HLS_PATH.$video->getAttribute('id').'/thumbnail/');
    }

    public function resolveHlsFile($video, $includeS3 = true): string
    {
        if (!$includeS3) {
            return self::HLS_PATH.$video->getAttribute('id').'/'.$video->getAttribute('id').'.m3u8';
        }

        return $this->resolver->resolveForPath(self::HLS_PATH.$video->getAttribute('id').'/'.$video->getAttribute('id').'.m3u8');
    }

    /**
     * @param FileInterface $video
     */
    public function resolveThumbnail($video): string
    {
        $id = $video->getAttribute('id');
        $files = $this->s3->files($this->resolveThumbnailPath($video));

        return 1 == count($files) ? self::HLS_PATH.$id.'/thumbnail/'.$id.'.0000000.jpg' :
            self::HLS_PATH.$id.'/thumbnail/'.$id.'.0000001.jpg';
    }

    public function resolvePublicM3u8(string $path): string
    {
        return $this->s3->url($path);
    }
}
