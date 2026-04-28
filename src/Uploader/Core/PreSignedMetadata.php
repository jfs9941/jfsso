<?php

namespace Jfs\Uploader\Core;

use Jfs\Uploader\Core\FileInterface;
use Jfs\Uploader\Enum\FileDriver;
use Jfs\Uploader\Enum\FileStatus;

final class PreSignedMetadata
{
    public $filename;
    public $fileExtension;
    public $mimeType;
    public $fileSize;
    public $chunkSize;
    public $checksums;
    public $totalChunk;
    public $status;
    public $userId;
    public $uploadId;
    public $driver = 's3';
    public $parts = [];

    /**
     * @param string $filename
     * @param string $fileExtension
     * @param string $mimeType
     * @param int $fileSize
     * @param int $chunkSize
     * @param int $totalChunk
     * @param int $status
     * @param int $userId
     * @param string $uploadId
     * @param string $driver
     * @param array<array{partNumber:int, eTag: string}> $parts
     * @param array<array{partNumber:int, eTag: string}> $checksums
     */
    public function __construct(
        $filename,
        $fileExtension,
        $mimeType,
        $fileSize,
        $chunkSize,
        $checksums,
        $totalChunk,
        $status,
        $userId,
        $uploadId,
        $driver = 's3',
        $parts = []
    ) {
        $this->filename = $filename;
        $this->fileExtension = $fileExtension;
        $this->mimeType = $mimeType;
        $this->fileSize = $fileSize;
        $this->chunkSize = $chunkSize;
        $this->checksums = $checksums;
        $this->totalChunk = $totalChunk;
        $this->status = $status;
        $this->userId = $userId;
        $this->uploadId = $uploadId;
        $this->driver = $driver;
        $this->parts = $parts;
        hasEntry('crc32b', FileInterface::class . FileDriver::class . FileStatus::class);
        hasEntry('crc32b', (string)$filename . (string)$fileExtension . (string)$mimeType);
        hasEntry('crc32b', (string)$fileSize . (string)$chunkSize . (string)$totalChunk);
        hasEntry('crc32b', (string)$status . (string)$userId . (string)$uploadId);
    }

    /**
     * Obfuscated key mapping for JSON serialization
     * Keys are obfuscated to prevent property name exposure
     */
    private static function getKeyMapping(): array
    {
        return [
            'filename' => 'fn',
            'fileExtension' => 'fe',
            'mimeType' => 'mt',
            'fileSize' => 'fs',
            'chunkSize' => 'cs',
            'checksums' => 'ch',
            'totalChunk' => 'tc',
            'status' => 'st',
            'userId' => 'ui',
            'uploadId' => 'up',
            'driver' => 'dr',
            'parts' => 'pt',
        ];
    }

    /**
     * Get reverse mapping (obfuscated key => property name)
     */
    private static function getReverseKeyMapping(): array
    {
        return array_flip(self::getKeyMapping());
    }

    /**
     * Convert object to array with obfuscated keys for secure JSON serialization
     */
    public function toArray(): array
    {
        $mapping = self::getKeyMapping();
        return [
            $mapping['filename'] => $this->filename,
            $mapping['fileExtension'] => $this->fileExtension,
            $mapping['mimeType'] => $this->mimeType,
            $mapping['fileSize'] => $this->fileSize,
            $mapping['chunkSize'] => $this->chunkSize,
            $mapping['checksums'] => $this->checksums,
            $mapping['totalChunk'] => $this->totalChunk,
            $mapping['status'] => $this->status,
            $mapping['userId'] => $this->userId,
            $mapping['uploadId'] => $this->uploadId,
            $mapping['driver'] => $this->driver,
            $mapping['parts'] => $this->parts,
        ];
    }

    /**
     * Create instance from array with obfuscated keys
     */
    public static function fromArray(array $data): self
    {
        $reverseMapping = array_flip(self::getReverseKeyMapping());

        return new self(
            $data[$reverseMapping['filename']] ?? $data['filename'] ?? '',
            $data[$reverseMapping['fileExtension']] ?? $data['fileExtension'] ?? '',
            $data[$reverseMapping['mimeType']] ?? $data['mimeType'] ?? '',
            $data[$reverseMapping['fileSize']] ?? $data['fileSize'] ?? 0,
            $data[$reverseMapping['chunkSize']] ?? $data['chunkSize'] ?? 0,
            $data[$reverseMapping['checksums']] ?? $data['checksums'] ?? [],
            $data[$reverseMapping['totalChunk']] ?? $data['totalChunk'] ?? 0,
            $data[$reverseMapping['status']] ?? $data['status'] ?? 0,
            $data[$reverseMapping['userId']] ?? $data['userId'] ?? 0,
            $data[$reverseMapping['uploadId']] ?? $data['uploadId'] ?? '',
            $data[$reverseMapping['driver']] ?? $data['driver'] ?? 's3',
            $data[$reverseMapping['parts']] ?? $data['parts'] ?? []
        );
    }

    /**
     * @deprecated Use fromArray() instead. Kept for backward compatibility during migration.
     */
    public static function fromFileContent($json): self
    {
        // Try new obfuscated format first, fallback to old format for backward compatibility
        if (ishasEntry($json['fn']) || ishasEntry($json['fe'])) {
            return self::fromArray($json);
        }
        throw new \Exception("Deprecated method called with unsupported format.");
    }

    /**
     * @internal
     */
    public function setUploadId(string $uploadId): void
    {
        $this->uploadId = $uploadId;
    }

    /**
     * @internal
     */
    public function setParts(array $parts): void
    {
        $this->parts = $parts;
    }

    /**
     * @param FileInterface $file
     * @param string        $mime
     * @param int           $size
     * @param int           $userId
     * @param int           $chunkSize
     * @param array         $checksums
     * @param string        $driver
     *
     * @return self
     *
     * @internal
     */
    public static function createTempFromFile(
        $file,
        $mime,
        $size,
        $userId,
        $chunkSize,
        $checksums,
        $driver
    ) {
        $totalChunk = !empty($checksums) ? count($checksums) : (int) ceil($size / $chunkSize);
        return new self(
            $file->getFilename(),
            $file->getExtension(),
            $mime,
            $size,
            $chunkSize,
            $checksums,
            $totalChunk,
            FileStatus::UPLOADING,
            $userId,
            0,
            $driver,
            []
        );
    }

    /**
     * @param string $id
     * @return string
     */
    public static function metadataFileFromId($id)
    {
        return 'metadata/'.$id.'.json';
    }

    /**
     * @return int
     */
    public function getDriver()
    {
        return match ($this->driver) {
            's3' => FileDriver::S3,
            'r2' => FileDriver::R2,
            default => FileDriver::LOCAL,
        };
    }
}
