<?php

namespace Jfs\Exposed\Jobs;

interface GenerateImageVersionsJobInterface
{
    /**
     * Generate small (300x300) and medium (max 1200px) versions of an image
     *
     * @param string $id The image ID
     * @return array Paths to generated versions ['small' => path, 'medium' => path]
     */
    public function generate(string $id): array;
}
