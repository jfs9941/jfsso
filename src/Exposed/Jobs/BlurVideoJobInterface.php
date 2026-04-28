<?php

namespace Jfs\Exposed\Jobs;

interface BlurVideoJobInterface
{
    public function blur(string $id): void;
}
