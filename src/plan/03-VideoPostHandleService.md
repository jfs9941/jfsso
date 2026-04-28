# Jfs\Uploader\Service\VideoPostHandleService

**File:** `smoke/Uploader/Service/VideoPostHandleService.php`

## Use Statements
```php
Aws\Sqs\SqsClient
Jfs\Exposed\SingleUploadInterface
Jfs\Exposed\UploadServiceInterface
Jfs\Exposed\VideoPostHandleServiceInterface
Jfs\Gallery\Model\Media
Jfs\Uploader\Core\BaseFileModel
Jfs\Uploader\Core\Video
Jfs\Uploader\Enum\FileStatus
Illuminate\Contracts\Filesystem\Filesystem
Illuminate\Support\Facades\Log
```

## Properties
- `private $uploadService`
- `private $s3`

## Methods with LOC > 5

| Method | LOC |
|--------|-----|
| saveMetadata | 66 |
| createThumbnail | 29 |
| storeThumbnail | 19 |
