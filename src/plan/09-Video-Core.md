# Jfs\Uploader\Core\Video

**File:** `smoke/Uploader/Core/Video.php`

## Use Statements
```php
Jfs\Uploader\Contracts\FileStateInterface
Jfs\Uploader\Contracts\PathResolverInterface
Jfs\Uploader\Core\Traits\FileCreationTrait
Jfs\Uploader\Core\Traits\StateMachineTrait
Jfs\Uploader\Enum\FileStatus
```

## Properties
- `property string $resolution`
- `property float $fps`
- `property string $hls_path`
- `property string $aws_media_converter_job_id`
- `property string $thumbnail_id`
- `property int $driver`

## Methods with LOC > 5

| Method | LOC |
|--------|-----|
| createFromScratch | 9 |
| width | 8 |
| height | 8 |
| boot | 14 |
| getView | 20 |
| getThumbnails | 8 |
| asVideo | 7 |
