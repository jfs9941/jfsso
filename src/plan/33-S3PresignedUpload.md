# Jfs\Uploader\Presigned\S3PresignedUpload

**File:** `smoke/Uploader/Presigned/S3PresignedUpload.php`

## Use Statements
```php
Aws\S3\S3Client
Jfs\Uploader\Core\PreSignedModel
Jfs\Uploader\Exception\ChunkAbortException
Jfs\Uploader\Exception\ChunkMergeException
Jfs\Uploader\Exception\InvalidTempFileException
Jfs\Uploader\Exception\S3ConfigException
Jfs\Uploader\Presigned\PresignedUploadInterface
Illuminate\Contracts\Filesystem\Filesystem
Webmozart\Assert\Assert
```

## Properties
- `private $preSignedModel`
- `private $localStorage`
- `private $s3Storage`
- `private $bucket`

## Methods with LOC > 5

| Method | LOC |
|--------|-----|
| generateUrls | 47 |
| abort | 19 |
| finish | 43 |
