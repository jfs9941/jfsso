<?php

namespace Jfs\Uploader\Service\Jobs;

use Illuminate\Contracts\Filesystem\Filesystem;
use Jfs\Exposed\Jobs\DownloadToLocalJobInterface;
use Jfs\Uploader\Core\Image;
use Illuminate\Support\Facades\Log;

class DownloadToLocalJob implements DownloadToLocalJobInterface
{
    private $s3;
    private $localDisk;


    /**
     * @param Filesystem $s3
     * @param Filesystem $localDisk
     */
    public function __construct($s3, $localDisk)
    {
        $this->s3 = $s3;
        $this->localDisk = $localDisk;
    }

    public function download(string $id): void
    {
        $file = Image::findOrFail($id);
        Log::info("Start download file to local", ['fileId' => $id, 'filename' => $file->getLocation()]);
        if ($this->localDisk->exists($file->getLocation())) {
            return;
        }

        $this->localDisk->put($file->getLocation(), $this->s3->get($file->getLocation()));
    }
}
