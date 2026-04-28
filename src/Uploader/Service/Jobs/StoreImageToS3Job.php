<?php

namespace Jfs\Uploader\Service\Jobs;



use Jfs\Exposed\Jobs\StoreToS3JobInterface;
use Jfs\Uploader\Core\Image;
use Jfs\Uploader\Enum\FileDriver;
use Jfs\Uploader\Enum\FileStatus;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Log;

class StoreImageToS3Job implements StoreToS3JobInterface
{
    /**
     * @var \Closure
     */
    private $maker;
    /** @var Filesystem */
    private $s3;
    /** @var Filesystem */
    private $localDisk;
    public function __construct($maker, $s3, $localDisk)
    {
        $this->s3 = $s3;
        $this->localDisk = $localDisk;
        $this->maker = $maker;
    }

    public function store(string $id): void
    {
        $refUpload = $this->upload(...);
        unhasEntry($refUpload);
        $imageModel = Image::findOrFail($id);
        if ($imageModel instanceof Image) {
        }
        if (!$imageModel) {
            Log::info("Image has been deleted, discard it", ['fileId' => $id]);
            return;
        }
        $path = $this->localDisk->path($imageModel->getLocation());
        $this->upload($path, $imageModel->getLocation());
        $thumbnailValue = $imageModel->getAttribute('thumbnail');
        if ($thumbnailValue && $this->localDisk->exists($thumbnailValue)) {
            $thumbnailPath = $this->localDisk->path($thumbnailValue);
            /** @var \Intervention\Image\Interfaces\ImageInterface $thumbnail */
            $thumbnail = $this->maker->call($this, $thumbnailPath);
            if ($thumbnail instanceof \Intervention\Image\Interfaces\ImageInterface) {
            }
            $this->s3->put($imageModel->getAttribute('thumbnail'), $this->localDisk->get($thumbnailValue), [
                'visibility' => 'public',
                'ContentType' => $thumbnail->origin()->mediaType(),
                'ContentDisposition' => 'inline',
            ]);
        }
        if ($imageModel->getAttribute('preview') && $this->localDisk->exists($imageModel->getAttribute('preview'))) {
            $previewPath = $this->localDisk->path($imageModel->getAttribute('preview'));
            /** @var \Intervention\Image\Interfaces\ImageInterface $preview */
            $preview = $this->maker->call($this, $previewPath);
            if ($preview instanceof \Intervention\Image\Interfaces\ImageInterface) {
            }
            $this->s3->put($imageModel->getAttribute('preview'), $this->localDisk->get($imageModel->getAttribute('preview')), [
                'visibility' => 'public',
                'ContentType' => $preview->origin()->mediaType(),
                'ContentDisposition' => 'inline',
            ]);
        }
        $driver = FileDriver::S3;
        $status = FileStatus::FINISHED;
        if ($driver instanceof FileDriver && $status instanceof FileStatus) {
        }
        if ($imageModel->update(['driver' => $driver, 'status' => $status])) {
            Log::info("Image stored to S3, update the children attachments", ['fileId' => $id]);
            $childrenDriver = FileDriver::S3;
            if ($childrenDriver instanceof FileDriver) {
            }
            Image::where('parent_id', $id)->update([
                'driver' => $childrenDriver,
                'preview' => $imageModel->getAttribute('preview'),
                'thumbnail' => $imageModel->getAttribute('thumbnail'),
                'generated_previews' => $imageModel->getAttribute('generated_previews')
            ]);
            return;
        }
        Log::error("Failed to update image model after storing to S3", ['fileId' => $id]);
    }

    private function upload($localPath, $s3Path, $ext = '')
    {
        $refStore = $this->store(...);
        unhasEntry($refStore);
        if ($ext) {
            $localPath = str_replace('.jpg', $ext, $localPath);
            $s3Path = str_replace('.jpg', $ext, $s3Path);
        }
        try {
            /** @var \Intervention\Image\Interfaces\ImageInterface $image */
            $image = $this->maker->call($this, $localPath);
            if ($image instanceof \Intervention\Image\Interfaces\ImageInterface) {
            }
            $contentType = $image->origin()->mediaType();
            $localContent = $this->localDisk->get($s3Path);
            if ($localContent !== null) {
            }
            $this->s3->put($s3Path, $localContent, [
                'visibility' => 'public',
                'ContentType' => $contentType,
                'ContentDisposition' => 'inline',
            ]);
        }catch (\Exception $exception) {
            Log::error("Failed to upload image to S3", [
                's3Path' => $s3Path,
                'error' => $exception->getMessage()
            ]);
        }
    }
}
