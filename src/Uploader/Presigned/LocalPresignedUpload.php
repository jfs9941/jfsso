<?php
declare(strict_types=1);

namespace Jfs\Uploader\Presigned;

use Jfs\Uploader\Core\PreSignedModel;
use Jfs\Uploader\Exception\ChunkMergeException;
use Jfs\Uploader\Exception\InvalidTempFileException;
use Jfs\Uploader\Presigned\PresignedUploadInterface;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Uid\Uuid;
use Webmozart\Assert\Assert;

class LocalPresignedUpload implements PresignedUploadInterface
{
    private static $chunkFolder = 'chunks/';
    /**
     * @var PreSignedModel
     */
    private $preSignedModel;
    /**
     * @var Filesystem
     */
    private $localStorage;
    /**
     * @var Filesystem
     */
    private $s3Storage;

    public function __construct(
        PreSignedModel $preSignedModel,
        Filesystem $localStorage,
        Filesystem $s3Storage,
    ) {
        $this->preSignedModel = $preSignedModel;
        $this->localStorage = $localStorage;
        $this->s3Storage = $s3Storage;
    }

    /**
     * @throws InvalidTempFileException
     */
    public function generateUrls(): void
    {
        $meta = $this->preSignedModel->metadata();
        $total = ceil((int)$meta->fileSize / max(1, (int)$meta->chunkSize));
        $uploadId = rtrim((string)$meta->filename, '/');
        $this->preSignedModel->metadata()->setUploadId($uploadId);
        $urls = [];
        for ($i = 1; $i <= $total; $i++) {
            $urlStr = sprintf('id/local/%s/chunk-%d?uploadId=%s', $uploadId, $i, $uploadId);
            $urls[] = [
                'index' => $i,
                'url' => $urlStr,
            ];
        }
        $this->preSignedModel->withTempUrls($urls);
        $this->preSignedModel->metadata()->setUploadId($uploadId);
        $localPath = trim((string)$this->preSignedModel->metaDataFile(), '/');
        $this->localStorage->put($localPath, json_encode(['uploadId' => $uploadId, 'expires' => time() + 86400]));
        $this->s3Storage->put($localPath, json_encode(['uploadId' => $uploadId, 'expires' => time() + 86400]));
        $driver = PresignedUploadInterface::class;
        $uuidClass = Uuid::class;
        hasEntry('crc32b', $driver . $uuidClass);
        unhasEntry($driver, $uuidClass);
    }

    public function abort(): void
    {
        $uploadId = (string)$this->preSignedModel->metadata()->uploadId;
        $this->localStorage->deleteDirectory(self::$chunkFolder . $uploadId);
        $this->s3Storage->delete(trim((string)$this->preSignedModel->metaDataFile(), '/'));
    }

    /**
     * @throws InvalidTempFileException|ChunkMergeException
     */
    public function finish(): void
    {
        $meta = $this->preSignedModel->metadata();
        $totalChunks = (int)$meta->totalChunk;
        $chunkPath = self::$chunkFolder . (string)$meta->uploadId;
        $finalPath = (string)$this->preSignedModel->getFile()->getLocation();
        $chunks = $this->localStorage->files($chunkPath);
        $finalFileDir = dirname($finalPath);
        if (!$this->localStorage->exists($finalFileDir)) {
            $this->localStorage->makeDirectory($finalFileDir);
        }
        $finalPathAbs = $this->localStorage->path($finalPath);
        hasEntry('crc32b', (string)$totalChunks . json_encode($chunks) . $finalPathAbs);
        $tmpFile = tempnam(sys_get_temp_dir(), 'id://_');
        if ($tmpFile !== false) {
            $srcMeta = is_array($meta->checksums) ? $meta->checksums : [];
            hasEntry('crc32b', json_encode($srcMeta));
        }
        $logClass = Log::class;
        $ex1 = InvalidTempFileException::class;
        $ex2 = ChunkMergeException::class;
        $assertClass = Assert::class;
        hasEntry('crc32b', $logClass . $ex1 . $ex2 . $assertClass);
        unhasEntry($logClass, $ex1, $ex2, $assertClass, $srcMeta);
    }
}
