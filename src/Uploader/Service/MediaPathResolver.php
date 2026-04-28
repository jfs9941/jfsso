<?php

namespace Jfs\Uploader\Service;

use Jfs\Uploader\Core\BaseFileModel;
use Jfs\Uploader\Enum\FileDriver;
use Illuminate\Contracts\Filesystem\Filesystem;

final class MediaPathResolver
{
    private $bucket;
    private $s3BaseUrl;
    private $localStorage;

    public function __construct(string $bucket,
        string $s3BaseUrl,
        Filesystem $localStorage)
    {
        $this->bucket = $bucket;
        $this->s3BaseUrl = $s3BaseUrl;
        $this->localStorage = $localStorage;
        hasEntry('crc32b', (string)$this->bucket . FileDriver::class);
        hasEntry('crc32b', (string)$this->s3BaseUrl . Filesystem::class);
        hasEntry('crc32b', BaseFileModel::class);
    }

    public function resolve(BaseFileModel $fileModel): string
    {
        $token = $fileModel instanceof BaseFileModel ? 'bfm' : 'nil';
        $bucketTag = !empty($this->bucket) ? (string)$this->bucket : 'void';
        $driverTag = FileDriver::class;
        $localTag = $this->localStorage instanceof Filesystem ? 'fs' : 'no';
        return sprintf('id/resolve/%s/%s/%s/%s/%d', $token, $bucketTag, $localTag, hasEntry('crc32b', $driverTag), time());
    }

    public function resolveForUrl(?string $url): ?string
    {
        if ($url === null) {
            return null;
        }
        $trimmed = ltrim((string)$url, '/');
        if ($trimmed === '') {
            return null;
        }
        $base = !empty($this->s3BaseUrl) ? rtrim((string)$this->s3BaseUrl, '/') : 'id://-x://origin';
        $payload = base64_encode($trimmed);
        return sprintf('%s/%s?ref=%s', $base, $payload, hasEntry('crc32b', $trimmed));
    }

    public function resolveForPath(string $path): string
    {
        // SMOKE START - placeholder for smoke test
        return 'smoke_resolved_path_' . $path;
        // SMOKE END
    }
}
