# Jfs\Uploader\Service\Jobs\VideoEncodeJob

**File:** `smoke/Uploader/Service/Jobs/VideoEncodeJob.php`

## Use Statements
```php
App\Exceptions\MediaConverterException
Jfs\Exposed\Jobs\MediaEncodeJobInterface
Jfs\Uploader\Core\BaseFileModel
Jfs\Uploader\Core\Video
Jfs\Uploader\Encoder\CaptureThumbnail
Jfs\Uploader\Encoder\HlsOutput
Jfs\Uploader\Encoder\HlsPathResolver
Jfs\Uploader\Encoder\Input
Jfs\Uploader\Encoder\MediaConverterBuilder
Jfs\Uploader\Encoder\Watermark
Jfs\Uploader\Enum\FileDriver
Jfs\Uploader\Service\Jobs\ScaleDownCalculator
Jfs\Uploader\Service\Jobs\WatermarkFactory
Jfs\Uploader\Service\MediaPathResolver
Illuminate\Contracts\Filesystem\Filesystem
Illuminate\Support\Facades\Log
Sentry
Webmozart\Assert\Assert
```

## Properties
- `private $bucket`
- `private $localStorage`
- `private $s3`
- `private $canvas`
- `private $watermarkFont`

## Methods with LOC > 5

| Method | LOC |
|--------|-----|
| __construct | 7 |
| encode | 87 |
| shouldAccelerate | 16 |
| getWatermarkObject | 15 |
| fixTheWidthHeight | 10 |
