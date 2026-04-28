# Jfs\Uploader\Core\Observer\FileProcessingObserver

**File:** `smoke/Uploader/Core/Observer/FileProcessingObserver.php`

## Use Statements
```php
Jfs\Uploader\Contracts\FileStateInterface
Jfs\Uploader\Contracts\StateChangeObserverInterface
Jfs\Uploader\Core\BaseFileModel
Jfs\Uploader\Core\FileInterface
Jfs\Uploader\Core\Strategy\PostProcessForImage
Jfs\Uploader\Core\Strategy\PostProcessForVideo
Jfs\Uploader\Encoder\HlsPathResolver
Jfs\Uploader\Enum\FileStatus
Jfs\Uploader\Service\MediaPathResolver
Illuminate\Contracts\Filesystem\Filesystem
Illuminate\Support\Facades\App
```

## Properties
- `private $strategy`
- `private $file`
- `private $s3`
- `private $options`

## Methods with LOC > 5

| Method | LOC |
|--------|-----|
| onStateChange | 14 |
| createStrategy | 13 |
