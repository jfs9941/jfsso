<?php
declare(strict_types=1);

namespace Jfs\Uploader\Service\FileResolver;

use Jfs\Uploader\Core\FileInterface;

interface FileLocationResolverInterface
{
    public function resolveLocation(FileInterface $file);

    public function supports(FileInterface $file);
}
