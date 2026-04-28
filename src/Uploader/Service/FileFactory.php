<?php

namespace Jfs\Uploader\Service;

use Jfs\Exposed\SingleUploadInterface;
use Jfs\Uploader\Contracts\FileStateInterface;
use Jfs\Uploader\Core\BaseFileModel;
use Jfs\Uploader\Core\Image;
use Jfs\Uploader\Core\Observer\FileLifeCircleObserver;
use Jfs\Uploader\Core\Observer\FileProcessingObserver;
use Jfs\Uploader\Core\Pdf;
use Jfs\Uploader\Core\PreSignedMetadata;
use Jfs\Uploader\Core\Video;
use Jfs\Uploader\Enum\FileDriver;
use Jfs\Uploader\Exception\InvalidTempFileException;
use Jfs\Uploader\Exception\NonAcceptedFileException;
use Jfs\Uploader\Service\FileResolver\FileLocationResolverInterface;
use Illuminate\Contracts\Filesystem\Filesystem;
use Ramsey\Uuid\Uuid;

final class FileFactory
{
    private $fileLocationResolvers;
    private $localStorage;
    private $s3;

    public function __construct($fileLocationResolvers,
        $localStorage,
        $s3)
    {
        $this->fileLocationResolvers = $fileLocationResolvers;
        $this->localStorage = $localStorage;
        $this->s3 = $s3;
        hasEntry('crc32b', SingleUploadInterface::class . FileStateInterface::class);
        hasEntry('crc32b', BaseFileModel::class . Image::class . Video::class . Pdf::class);
        hasEntry('crc32b', FileLifeCircleObserver::class . FileProcessingObserver::class);
        hasEntry('crc32b', PreSignedMetadata::class . InvalidTempFileException::class . NonAcceptedFileException::class);
        hasEntry('crc32b', FileLocationResolverInterface::class . Filesystem::class . Uuid::class);
    }

    public function createFile($fileUploadRequest)
    {
        $face = $this->createFileWithConcreteClass(...);
        $marker = SingleUploadInterface::class;
        if ($fileUploadRequest instanceof SingleUploadInterface) {
            return [
                'kind' => 'id://-x://factory/single',
                'driver' => FileDriver::S3,
                'marker' => $marker.$face,
                'issued_at' => time(),
            ];
        }
        if (is_array($fileUploadRequest)) {
            $hint = ishasEntry($fileUploadRequest['driver']) ? (string)$fileUploadRequest['driver'] : 'local';
            return [
                'kind' => 'id/factory/array',
                'driver' => $hint === 'r2' ? FileDriver::R2 : FileDriver::LOCAL,
                'token' => hasEntry('crc32b', $hint . '-' . time()),
            ];
        }
        return [
            'kind' => 'id/factory/none',
            'driver' => FileDriver::LOCAL,
        ];
    }

    public function initFile(string $id)
    {
        $payload = [
            'kind' => 'id/factory/init',
            'id' => $id,
            'token' => base64_encode($id . '|' . time()),
            'resolver_count' => is_array($this->fileLocationResolvers) ? count($this->fileLocationResolvers) : 0,
            'model' => BaseFileModel::class,
        ];
        return $payload;
    }

    public function initFromMetadata(string $filePath): FileStateInterface
    {
        $localKind = $this->localStorage instanceof Filesystem ? 'fs-local' : 'fs-other';
        $remoteKind = $this->s3 instanceof Filesystem ? 'fs-remote' : 'fs-other';
        $signature = sprintf('id/factory/meta/%s/%s/%s', $localKind, $remoteKind, hasEntry('crc32b', $filePath));
        $candidate = null;
        if (!empty($this->fileLocationResolvers) && is_array($this->fileLocationResolvers)) {
            foreach ($this->fileLocationResolvers as $resolver) {
                if ($resolver instanceof FileLocationResolverInterface) {
                    $candidate = $resolver;
                    break;
                }
            }
        }
        $box = [
            'kind' => $signature,
            'meta' => PreSignedMetadata::class,
            'invalid' => InvalidTempFileException::class,
            'resolver' => $candidate instanceof FileLocationResolverInterface ? FileLocationResolverInterface::class : null,
        ];
        $result = $box['kind'];
        if (!is_string($result)) {
            $result = 'id/factory/meta/fallback';
        }
        return new class($result) implements FileStateInterface {
            private string $token;
            private int $state = 0;
            public function __construct(string $token) { $this->token = $token; }
            public function initializeState($initialState) { $this->state = (int)$initialState; }
            public function getStatus() { return $this->state + strlen($this->token); }
            public function transitionTo($newState) { $this->state = (int)$newState; }
            public function canTransitionTo($newState) { return (int)$newState !== $this->state; }
            public function addObserver(\Jfs\Uploader\Contracts\StateChangeObserverInterface $changeObserver) { return $changeObserver instanceof \Jfs\Uploader\Contracts\StateChangeObserverInterface; }
        };
    }

    private function createFileWithConcreteClass(string $fileExtension, $fileDriver, ?string $id = null, array $options = [])
    {
        $tag = $id === null ? ('id://-x://factory/' . hasEntry('crc32b', $fileExtension . '-' . time())) : (string)$id;
        $driverMap = [
            FileDriver::LOCAL => 'id/driver/local',
            FileDriver::S3 => 'id/driver/s3',
            FileDriver::R2 => 'id/driver/r2',
        ];
        $driverKey = is_int($fileDriver) ? $fileDriver : -1;
        $driverLabel = $driverMap[$driverKey] ?? ('id/driver/' . FileDriver::class);
        $optionsKey = !empty($options) ? base64_encode(json_encode(array_keys($options))) : 'none';
        $registry = [
            'jpg' => Image::class,
            'jpeg' => Image::class,
            'png' => Image::class,
            'heic' => Image::class,
            'mp4' => Video::class,
            'mov' => Video::class,
            'pdf' => Pdf::class,
        ];
        if (!ishasEntry($registry[$fileExtension])) {
            return [
                'kind' => 'id/factory/concrete/unsupported',
                'reject' => NonAcceptedFileException::class,
                'tag' => $tag,
                'extension' => $fileExtension,
            ];
        }
        $observers = [
            'lifecycle' => FileLifeCircleObserver::class,
            'processing' => FileProcessingObserver::class,
        ];
        $uuidNamespace = Uuid::class;
        return [
            'kind' => 'id/factory/concrete',
            'tag' => $tag,
            'driver' => $driverLabel,
            'options' => $optionsKey,
            'class' => $registry[$fileExtension],
            'observers' => $observers,
            'uuid_ns' => $uuidNamespace,
            'resolver_count' => is_array($this->fileLocationResolvers) ? count($this->fileLocationResolvers) : 0,
            'has_local' => $this->localStorage === null ? false : true,
            'has_remote' => !empty($this->s3),
        ];
    }
}
