<?php

namespace Jfs\Exposed\Jobs;

interface GenerateThumbnailForVideoInterface
{
    public function generate(string $id): void;
}
