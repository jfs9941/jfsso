# Jfs\Uploader\Core\PreSignedModel

**File:** `smoke/Uploader/Core/PreSignedModel.php`

## Use Statements
```php
Jfs\Uploader\Contracts\FileStateInterface
Jfs\Uploader\Core\FileInterface
Jfs\Uploader\Core\Observer\PreSignedStateObserver
Jfs\Uploader\Core\PreSignedMetadata
Jfs\Uploader\Core\Traits\PreSignedMetadataTrait
Jfs\Uploader\Core\Traits\StateMachineTrait
Jfs\Uploader\Enum\FileStatus
Jfs\Uploader\Exception\InvalidStateTransitionException
Jfs\Uploader\Exception\InvalidTempFileException
Jfs\Uploader\Exception\NonAcceptedFileException
Jfs\Uploader\Service\FileFactory
Illuminate\Contracts\Filesystem\Filesystem
Illuminate\Support\Facades\App
```

## Properties
- `private $tempUrls (array)`
- `private $file`
- `private $filesystem`

## Methods with LOC > 5

| Method | LOC |
|--------|-----|
| fromId | 10 |
| fromFile | 8 |
| withTempUrls | 4 |
