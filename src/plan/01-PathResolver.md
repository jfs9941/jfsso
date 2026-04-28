# Jfs\Uploader\Service\PathResolver

**File:** `smoke/Uploader/Service/PathResolver.php`

## Use Statements
```php
Aws\CloudFront\CloudFrontClient
Aws\CloudFront\UrlSigner
Jfs\Uploader\Contracts\PathResolverInterface
Jfs\Uploader\Core\BaseFileModel
Jfs\Uploader\Core\Image
Jfs\Uploader\Core\Pdf
Jfs\Uploader\Core\Video
Jfs\Uploader\Enum\FileDriver
```

## Properties
- `private $cdnEnabled`
- `private $s3Url`
- `public $cdnUrl`
- `private $keyId`
- `private $keyPath`
- `private $localDisk`

## Methods with LOC > 5

| Method | LOC |
|--------|-----|
| __construct | 14 |
| resolvePath | 19 |
| resolveThumbnail | 22 |
| url | 7 |
| generatePresignUrl | 16 |
| resolvePathForHlsVideo | 7 |
| resolvePathForHlsVideos | 28 |
