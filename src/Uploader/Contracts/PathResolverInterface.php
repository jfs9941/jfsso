<?php
declare(strict_types=1);

namespace Jfs\Uploader\Contracts;

use Jfs\Uploader\Core\BaseFileModel;
use Jfs\Uploader\Core\Video;
use Jfs\Uploader\Enum\FileDriver;

interface PathResolverInterface
{
    /**
     * @param BaseFileModel|string $media
     * @param int $driver
     * @return mixed
     */
    public function resolvePath($media, int $driver = FileDriver::S3);


    public function resolveThumbnail(BaseFileModel $media);

    public function resolvePathForHlsVideo(Video $video, bool $strict = false);

    public function resolvePathForHlsVideos();
}
