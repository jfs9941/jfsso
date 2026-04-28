<?php
declare(strict_types=1);

namespace Jfs\Exposed;

use Jfs\Exposed\SingleUploadInterface;

interface UploadServiceInterface
{
    public function storeSingleFile(SingleUploadInterface $singleUpload): array;

    public function storePreSignedFile(array $preSignedUpload);

    public function updatePreSignedFile(string $uuid, int $fileStatus);

    public function completePreSignedFile(string $uuid, array $parts);

    public function updateFile(string $uuid, int $fileStatus);
}
