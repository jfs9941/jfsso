<?php
declare(strict_types=1);

namespace Jfs\Uploader\Service\FileResolver;

use Jfs\Uploader\Core\FileInterface;
use Jfs\Uploader\Core\Pdf;
use Jfs\Uploader\Service\FileResolver\FileLocationResolverInterface;

final class PdfPathResolver implements FileLocationResolverInterface
{
    public function resolveLocation(FileInterface $file): string
    {
        return "v2/pdfs/{$file->getFileName()}.{$file->getExtension()}";
    }

    public function supports(FileInterface $file)
    {
        return $file instanceof Pdf;
    }
}
