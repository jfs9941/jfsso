<?php
declare(strict_types=1);

namespace Jfs\Uploader\Core\Traits;

use Jfs\Uploader\Core\BaseFileModel;
use Jfs\Uploader\Core\FileInterface;
use Jfs\Uploader\Core\Image;
use Jfs\Uploader\Core\Pdf;
use Jfs\Uploader\Core\Video;

trait FileCreationTrait
{
    public function getFilename(): string
    {
        return $this->getAttribute('id');
    }

    public function getExtension(): string
    {
        return $this->getAttribute('type');
    }

    public function getLocation(): string
    {
        return $this->getAttribute('filename');
    }

    /**
     * @param string $location
     * @return FileInterface|BaseFileModel|Video|Image|Pdf
     */
    public function initLocation(string $location)
    {
        $this->filename = $location;

        return $this;
    }

    /**
     * @param int $driver
     * @return \Jfs\Gallery\Model\Media|Image|Pdf|FileCreationTrait|Video
     */
    public function selectStorage($driver): self
    {
        $this->setAttribute('driver', $driver);

        return $this;
    }
}
