# Jfs\Uploader\Service\Jobs\GenerateImageVersions

**File:** `smoke/Uploader/Service/Jobs/GenerateImageVersions.php`

## Use Statements
```php
Jfs\Exposed\Jobs\GenerateImageVersionsJobInterface
Jfs\Uploader\Core\Image
Illuminate\Database\Eloquent\ModelNotFoundException
Illuminate\Support\Facades\Log
```

## Properties
- `const SMALL_SIZE = 300`
- `const MEDIUM_MAX_SIZE = 1200`
- `const QUALITY = 80`
- `private $maker`
- `private $localDisk`
- `private $s3Disk`

## Methods with LOC > 5

| Method | LOC |
|--------|-----|
| generate | 83 |
| generateSmallVersion | 57 |
| generateMediumVersion | 51 |
