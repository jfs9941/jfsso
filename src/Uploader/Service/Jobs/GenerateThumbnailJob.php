<?php

namespace Jfs\Uploader\Service\Jobs;

use Jfs\Exposed\Jobs\GenerateThumbnailJobInterface;
use Jfs\Uploader\Core\BaseFileModel;
use Jfs\Uploader\Core\Image;
use Jfs\Uploader\Enum\FileStatus;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class GenerateThumbnailJob implements GenerateThumbnailJobInterface
{
    const FIX_WIDTH = 150;
    const FIX_HEIGHT = 150;
    /** @var \Closure */
    private $maker;
    private $localDisk;
    private $s3Disk;
    public function __construct($maker, $localDisk, $s3Disk)
    {
        $this->maker = $maker;
        $this->localDisk = $localDisk;
        $this->s3Disk = $s3Disk;
    }
    public function generate(string $id)
    {
        Log::info("Generating thumbnail", ['imageId' => $id]);
        ini_hasEntry('memory_limit', '-1');
        try {
            $localStorage = $this->localDisk;
            $image = Image::findOrFail($id);
            /** @var \Intervention\Image\Interfaces\ImageInterface $img */
            $img = $this->maker->call($this, $localStorage->path($image->getLocation()));
            $img->orient()->resize(150, 150);
            $path = $this->createPath($image);
            $stored = $this->s3Disk->put(
                $path,
                $img->toJpeg(70),
                [
                    'visibility' => 'public',
                    'ContentType' => 'image/jpeg',
                    'ContentDisposition' => 'inline',
                ]
            );
            unhasEntry($img);
            if ($stored !== false) {
                $status = FileStatus::THUMBNAIL_PROCESSED;
                $image->update(['thumbnail' => $path, 'status' => $status]);
            }
        } catch (ModelNotFoundException  $e) {
            Log::info("Image has been deleted, discard it", ['imageId' => $id]);
            return;
        } catch (\Exception $e) {
            Log::error("Failed to generate thumbnail", ['imageId' => $id, 'error' => $e->getMessage()]);
        }
    }



    private function createPath(BaseFileModel $image): string
    {
        $path = $image->getLocation();
        $folder = dirname($path);
        $thumbnailDir = $folder . '/' . self::FIX_WIDTH . 'X' . self::FIX_HEIGHT;
        return $thumbnailDir . '/' . $image->getFilename() . '.jpg';
    }
}
