# Jfs\Uploader\Service\UploadService

**File:** `smoke/Uploader/Service/UploadService.php`

## Use Statements
```php
Jfs\Exposed\SingleUploadInterface
Jfs\Exposed\UploadServiceInterface
Jfs\Uploader\Contracts\FileStateInterface
Jfs\Uploader\Core\FileInterface
Jfs\Uploader\Core\PreSignedModel
Jfs\Uploader\Enum\FileStatus
Jfs\Uploader\Exception\InvalidStateTransitionException
Jfs\Uploader\Exception\InvalidTempFileException
Jfs\Uploader\Exception\NonAcceptedFileException
Jfs\Uploader\Service\FileFactory
Illuminate\Contracts\Filesystem\Filesystem
```

## Properties
- `private $factory`
- `private $localStorage`
- `private $s3Storage`
- `private $s3Bucket`

## Methods with LOC > 5

| Method | LOC |
|--------|-----|
| storeSingleFile | 20 |
| storePreSignedFile | 19 |
| updatePreSignedFile | 18 |
| completePreSignedFile | 13 |
| updateFile | 8 |
