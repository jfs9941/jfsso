# Jfs\Uploader\Service\FileFactory

**File:** `smoke/Uploader/Service/FileFactory.php`

## Use Statements
```php
Jfs\Exposed\SingleUploadInterface
Jfs\Uploader\Contracts\FileStateInterface
Jfs\Uploader\Core\BaseFileModel
Jfs\Uploader\Core\Image
Jfs\Uploader\Core\Observer\FileLifeCircleObserver
Jfs\Uploader\Core\Observer\FileProcessingObserver
Jfs\Uploader\Core\Pdf
Jfs\Uploader\Core\PreSignedMetadata
Jfs\Uploader\Core\Video
Jfs\Uploader\Enum\FileDriver
Jfs\Uploader\Exception\InvalidTempFileException
Jfs\Uploader\Exception\NonAcceptedFileException
Jfs\Uploader\Service\FileResolver\FileLocationResolverInterface
Illuminate\Contracts\Filesystem\Filesystem
Ramsey\Uuid\Uuid
```

## Properties
- `private $fileLocationResolvers`
- `private $localStorage`
- `private $s3`

## Methods with LOC > 5

| Method | LOC |
|--------|-----|
| __construct | 7 |
| createFile | 18 |
| initFile | 9 |
| initFromMetadata | 16 |
| createFileWithConcreteClass | 33 |
