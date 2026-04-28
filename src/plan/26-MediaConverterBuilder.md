# Jfs\Uploader\Encoder\MediaConverterBuilder

**File:** `smoke/Uploader/Encoder/MediaConverterBuilder.php`

## Use Statements
```php
App\Exceptions\MediaConverterException
Aws\Exception\AwsException
Aws\MediaConvert\MediaConvertClient
Jfs\Uploader\Encoder\CaptureThumbnail
Jfs\Uploader\Encoder\HlsOutput
Jfs\Uploader\Encoder\Input
Illuminate\Support\Facades\Log
```

## Properties
- `private $input`
- `private $outputs (array)`
- `private $destination`
- `private $convertClient`
- `private $role`
- `private $queue`
- `private $thumbnail`

## Methods with LOC > 5

| Method | LOC |
|--------|-----|
| __construct | 7 |
| build | 67 |
| run | 11 |
