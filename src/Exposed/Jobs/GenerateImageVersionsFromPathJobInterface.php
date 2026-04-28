<?php

namespace Jfs\Exposed\Jobs;

interface GenerateImageVersionsFromPathJobInterface
{
    /**
     * Generate small (300x300) and medium (max 1200px) versions from an S3 path
     *
     * @param string $s3Path The source S3 path (e.g., "folder/photo.jpg")
     * @return array Paths to generated versions ['small' => path, 'medium' => path]
     */
    public function generate(string $s3Path): array;
}
