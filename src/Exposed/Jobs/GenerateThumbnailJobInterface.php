<?php

namespace Jfs\Exposed\Jobs;

interface GenerateThumbnailJobInterface
{
    public function generate(string $id);
}
