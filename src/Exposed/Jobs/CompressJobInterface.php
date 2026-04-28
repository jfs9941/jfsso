<?php

namespace Jfs\Exposed\Jobs;

interface CompressJobInterface
{
    public function compress(string $id);
}
