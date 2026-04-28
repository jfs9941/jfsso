<?php

namespace Jfs\Exposed\Jobs;

interface BlurJobInterface
{
    public function blur(string $id): void;
}
