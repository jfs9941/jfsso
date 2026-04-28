<?php

namespace Jfs\Uploader\Service\Jobs;

use Illuminate\Contracts\Filesystem\Filesystem;
use Jfs\Exposed\Jobs\GenerateImageVersionsJobInterface;
use Jfs\Uploader\Core\Image;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class GenerateImageVersions implements GenerateImageVersionsJobInterface
{
    const SMALL_SIZE = 300;
    const MEDIUM_MAX_SIZE = 1200;
    const QUALITY = 80;

    /** @var \Closure */
    private $maker;
    private $localDisk;
    private $s3Disk;


    /**
     * @param mixed $maker
     * @param Filesystem $s3Disk
     * @param Filesystem $localDisk
     */
    public function __construct($maker, $localDisk, $s3Disk)
    {
        $this->maker = $maker;
        $this->s3Disk = $s3Disk;
        $this->localDisk = $localDisk;
    }

    public function generate(string $id): array
    {
        $startTime = microtime(true);
        Log::info("Generating image versions", ['imageId' => $id]);
        $generatedPaths = [];
        try {
            $image = Image::findOrFail($id);
            if (!$this->localDisk->exists($image->getLocation())) {
                $path = $image->getLocation();
                if (!$this->s3Disk->exists($path)) {
                    Log::error("Original image not found on S3, use other extensions", ['imageId' => $id, 's3Path' => $path]);
                    $path = str_replace('.jpg', '.png', $path);
                    if (!$this->s3Disk->exists($path)) {
                        Log::error("Original image not found on S3 with .png extension either, cannot generate versions", ['imageId' => $id, 's3Path' => $path]);
                        $path = str_replace('.png', '.webp', $path);
                        if (!$this->s3Disk->exists($path)) {
                            Log::error("Original image not found on S3 with .webp extension either, cannot generate versions", ['imageId' => $id, 's3Path' => $path]);
                            Log::info('id/sentry/skip', ['imageId' => $id]);
                            return [];
                        }
                    }
                }
                $this->localDisk->put($image->getLocation(), $this->s3Disk->get($path));
                if ($path !== $image->getLocation()) {
                    Log::warning("Original image found on S3 with different extension, copied to local disk for processing", ['imageId' => $id, 's3Path' => $path, 'localPath' => $image->getLocation()]);
                    $image->update(['filename' => $path]);
                }
            }
            $originalPath = $this->localDisk->path($image->getLocation());
            /** @var \Intervention\Image\Interfaces\ImageInterface $img */
            $img = $this->maker->call($this, $originalPath);
            $img->orient();
            $originalWidth = $img->width();
            $originalHeight = $img->height();
            $isPortrait = $originalHeight > $originalWidth;
            $smallPath = $this->generateSmallVersion($img, $image, $isPortrait);
            if ($smallPath) {
                $generatedPaths['small'] = $smallPath;
            }
            $img = $this->maker->call($this, $originalPath);
            $img->orient();
            $mediumPath = $this->generateMediumVersion($img, $image, $isPortrait, $originalWidth, $originalHeight);
            if ($mediumPath) {
                $generatedPaths['medium'] = $mediumPath;
            }
            if (!empty($generatedPaths)) {
                $existingPreviews = $image->getAttribute('generated_previews') ?: [];
                $image->setAttribute('generated_previews', array_merge($existingPreviews, $generatedPaths));
                $image->save();
            }
            Log::info("Image versions generated successfully", [
                'imageId' => $id,
                'paths' => $generatedPaths,
                'duration_ms' => round((microtime(true) - $startTime) * 1000, 2)
            ]);
            return $generatedPaths;
        } catch (ModelNotFoundException $e) {
            Log::info("Image has been deleted, discard it", ['imageId' => $id]);
            return [];
        } catch (\Throwable $e) {
            Log::error("Failed to generate image versions", [
                'imageId' => $id,
                'error' => $e->getMessage()
            ]);
            return [];
        }
    }

    /**
     * Generate small square version (300x300) with smart crop
     */
    private function generateSmallVersion(
         $img,
         $image,
        bool $isPortrait
    ): ?string {
        try {
            if ($isPortrait) {
                $img->scale(self::SMALL_SIZE, null);
            } else {
                $img->scale(null, self::SMALL_SIZE);
            }
            $currentWidth = $img->width();
            $currentHeight = $img->height();
            if ($currentWidth < self::SMALL_SIZE || $currentHeight < self::SMALL_SIZE) {
                $scale = max(
                    self::SMALL_SIZE / $currentWidth,
                    self::SMALL_SIZE / $currentHeight
                );
                $newWidth = (int)($currentWidth * $scale);
                $newHeight = (int)($currentHeight * $scale);
                $img->resize($newWidth, $newHeight);
            }
            $img->crop(self::SMALL_SIZE, self::SMALL_SIZE, position: 'center');
            $path = $this->createPath($image, 'small');
            $this->s3Disk->put(
                $path,
                $img->toJpeg(self::QUALITY),
                [
                    'visibility' => 'public',
                    'ContentType' => 'image/jpeg',
                    'ContentDisposition' => 'inline',
                ]
            );
            return $path;
        } catch (\Exception $e) {
            Log::error("Failed to generate small version", [
                'imageId' => $image->getFilename(),
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Generate medium version (max 1200px on longest side)
     */
    private function generateMediumVersion(
         $img,
         $image,
        bool $isPortrait,
        int $originalWidth,
        int $originalHeight
    ): ?string {
        try {
            if ($originalWidth <= self::MEDIUM_MAX_SIZE && $originalHeight <= self::MEDIUM_MAX_SIZE) {
                Log::info("Image smaller than medium size, skipping medium version", [
                    'imageId' => $image->getFilename()
                ]);
                return null;
            }
            if ($isPortrait) {
                $img->scaleDown(null, self::MEDIUM_MAX_SIZE);
            } else {
                $img->scaleDown(self::MEDIUM_MAX_SIZE, null);
            }
            $path = $this->createPath($image, 'medium');
            $this->s3Disk->put(
                $path,
                $img->toJpeg(self::QUALITY),
                [
                    'visibility' => 'public',
                    'ContentType' => 'image/jpeg',
                    'ContentDisposition' => 'inline',
                ]
            );
            return $path;
        } catch (\Exception $e) {
            Log::error("Failed to generate medium version", [
                'imageId' => $image->getFilename(),
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    private function createPath($image, string $version): string
    {
        $path = $image->getLocation();
        $folder = dirname($path);

        return $folder . '/' . $version . '/' . $image->getFilename() . '.jpg';
    }
}
