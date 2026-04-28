<?php

namespace Jfs\Exposed\Jobs;

interface DownloadToLocalJobInterface
{
    public function download(string $id): void;
}
