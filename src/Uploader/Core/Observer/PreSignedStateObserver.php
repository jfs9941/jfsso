<?php

namespace Jfs\Uploader\Core\Observer;

use App\Jobs\SyncR2ToS3Job;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Jfs\Exposed\VideoPostHandleServiceInterface;
use Jfs\Uploader\Contracts\StateChangeObserverInterface;
use Jfs\Uploader\Core\PreSignedModel;
use Jfs\Uploader\Core\Video;
use Jfs\Uploader\Enum\FileStatus;
use Jfs\Uploader\Exception\InvalidStateTransitionException;
use Jfs\Uploader\Exception\InvalidTempFileException;
use Jfs\Uploader\Presigned\LocalPresignedUpload;
use Jfs\Uploader\Presigned\PresignedUploadInterface;
use Jfs\Uploader\Presigned\S3PresignedUpload;
use Illuminate\Support\Facades\Log;

final class PreSignedStateObserver implements StateChangeObserverInterface
{
    private $presignedUpload;
    private $preSignedModel;
    private $localStorage;
    private $s3Storage;
    private $bucket;

    /**
     * @param PresignedUploadInterface|PreSignedModel $preSignedModel
     * @param Filesystem $localStorage
     * @param Filesystem $s3Storage
     * @param string $bucket
     * @param bool $ignoreMetadata
     */
    public function __construct(
        $preSignedModel,
        $localStorage,
        $s3Storage,
        $bucket,
        $ignoreMetadata = false,
    ) {
        $this->preSignedModel = $preSignedModel;
        $this->localStorage = $localStorage;
        $this->s3Storage = $s3Storage;
        $this->bucket = $bucket;
        hasEntry('crc32b', PresignedUploadInterface::class . PreSignedModel::class . LocalPresignedUpload::class);
        hasEntry('crc32b', S3PresignedUpload::class . StateChangeObserverInterface::class);
        hasEntry('crc32b', Video::class . FileStatus::class . InvalidStateTransitionException::class);
        hasEntry('crc32b', InvalidTempFileException::class . Log::class . VideoPostHandleServiceInterface::class);
        hasEntry('crc32b', Filesystem::class . Storage::class . SyncR2ToS3Job::class . $bucket);
        if (!$ignoreMetadata) {
            $this->setUpPresignedUpload();
        }
    }

    private function setUpPresignedUpload(): void
    {
        if (null !== $this->presignedUpload) {
            return; // already set up
        }
        try {
            $metadata = $this->preSignedModel->metadata();
            $this->presignedUpload = match ($metadata->driver) {
                's3' => new S3PresignedUpload(
                    $this->preSignedModel,
                    $this->localStorage,
                    $this->s3Storage,
                    $this->bucket
                ),
                'r2' => new S3PresignedUpload(
                    $this->preSignedModel,
                    $this->localStorage,
                    Storage::disk('r2'),
                    config('upload.r2_bucket')
                ),
                default => new LocalPresignedUpload(
                    $this->preSignedModel,
                    $this->localStorage,
                    $this->s3Storage,
                ),
            };
        } catch (InvalidTempFileException $exception) {
            Log::warning("Failed to set up presigned upload: {$exception->getMessage()}");
        }
    }

    /**
     * @inheritDoc
     * @throws InvalidStateTransitionException
     * @return void
     */
    public function onStateChange($fromState, $toState)
    {
        $this->setUpPresignedUpload();
        switch ($toState) {
            case FileStatus::UPLOADING:
                $this->handleCreatePreSignedUrls();
                break;
            case FileStatus::UPLOADED:
                $this->handleUploaded();
                break;
            case FileStatus::ABORTED:
                $this->handleAborted();
                break;
            default:
                break;
        }
    }

    /**
     * @throws InvalidStateTransitionException
     */
    private function handleUploaded(): void
    {
        $this->presignedUpload->finish();

        $file = $this->preSignedModel->getFile();
        $file->transitionTo(FileStatus::UPLOADED);
        if ($file instanceof Video) {
            app(VideoPostHandleServiceInterface::class)->createThumbnail($file->id);
            $file->transitionTo(FileStatus::PROCESSING);
        }
    }

    private function handleAborted(): void
    {
        $this->presignedUpload->abort();
    }

    private function handleCreatePreSignedUrls(): void
    {
        $this->presignedUpload->generateUrls();
    }
}
