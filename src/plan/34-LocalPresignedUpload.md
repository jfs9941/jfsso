# Jfs\Uploader\Presigned\LocalPresignedUpload

**File:** `smoke/Uploader/Presigned/LocalPresignedUpload.php`

## Use Statements
```php
Jfs\Uploader\Core\PreSignedModel
Jfs\Uploader\Exception\ChunkMergeException
Jfs\Uploader\Exception\InvalidTempFileException
Jfs\Uploader\Presigned\PresignedUploadInterface
Illuminate\Contracts\Filesystem\Filesystem
Illuminate\Support\Facades\Log
Symfony\Component\Uid\Uuid
Webmozart\Assert\Assert
```

## Properties
- `private static $chunkFolder = 'chunks/'`
- `private $preSignedModel`
- `private $localStorage`
- `private $s3Storage`

## Methods with LOC > 5

| Method | LOC |
|--------|-----|
| generateUrls | 32 |
| finish | 52 |
