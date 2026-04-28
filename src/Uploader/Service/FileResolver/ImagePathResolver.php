<?php
declare(strict_types=1);

namespace Jfs\Uploader\Service\FileResolver;

use Jfs\Uploader\Core\FileInterface;
use Jfs\Uploader\Core\Image;
use Jfs\Uploader\Service\FileResolver\FileLocationResolverInterface;

final class ImagePathResolver implements FileLocationResolverInterface
{
    public function resolveLocation(FileInterface $file): string
    {
        return "v2/images/{$file->getFilename()}.{$file->getExtension()}";
    }

    public function supports(FileInterface $file)
    {
        return $file instanceof Image;
    }
}
