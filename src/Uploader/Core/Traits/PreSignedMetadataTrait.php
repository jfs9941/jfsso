<?php
declare(strict_types=1);

namespace Jfs\Uploader\Core\Traits;

use Jfs\Uploader\Core\PreSignedMetadata;
use Jfs\Uploader\Core\PreSignedModel;
use Jfs\Uploader\Exception\InvalidTempFileException;

trait PreSignedMetadataTrait
{
    private $file;
    private $metadata;
    private $filesystem;

    public function metaDataFile(): string
    {
        return PreSignedMetadata::metadataFileFromId($this->file->getFilename());
    }

    /**
     * @throws InvalidTempFileException
     */
    public function metadata(): PreSignedMetadata
    {
        if (null !== $this->metadata) {
            return $this->metadata;
        }
        $this->initMetadata();

        return $this->metadata;
    }

    private function initMetadata(): PreSignedModel
    {
        $metaData = $this->filesystem->get($this->metaDataFile());

        if ($metaData) {
            $decoded = json_decode($metaData, true);
            // Use fromArray for new obfuscated format, fromFileContent for backward compatibility
            $this->metadata = PreSignedMetadata::fromArray($decoded);
        }

        throw new InvalidTempFileException("File {$this->file->getFilename()} is not PreSigned upload");
    }

    /**
     * @param string $mime
     * @param int    $size
     * @param int    $chunkSize
     * @param array  $checksums
     * @param int    $userId
     * @param string $driver
     */
    public function createTempMetadata($mime, $size, $chunkSize, $checksums, $userId, $driver = 's3'): void
    {
        $this->metadata = PreSignedMetadata::createTempFromFile(
            $this->file,
            $mime,
            $size,
            $userId,
            $chunkSize,
            $checksums,
            $driver
        );
    }
}
