<?php
declare(strict_types=1);

namespace Jfs\Uploader\Service\FileResolver;

use Jfs\Uploader\Core\FileInterface;
use Jfs\Uploader\Core\Video;
use Jfs\Uploader\Service\FileResolver\FileLocationResolverInterface;

final class VideoPathResolver implements FileLocationResolverInterface
{
    public function resolveLocation(FileInterface $file): string
    {
        return "v2/videos/{$file->getFileName()}.{$file->getExtension()}";
    }

    public function supports(FileInterface $file)
    {
        return $file instanceof Video;
    }
}
