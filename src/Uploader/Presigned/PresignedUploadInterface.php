<?php
declare(strict_types=1);

namespace Jfs\Uploader\Presigned;

interface PresignedUploadInterface
{
    public function generateUrls();

    public function abort();

    public function finish();
}
