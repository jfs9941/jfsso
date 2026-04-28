# Jfs\Gallery\Model\Media

**File:** `smoke/Gallery/Model/Media.php`

## Use Statements
```php
Jfs\Gallery\Model\Enum\MediaTypeEnum
Jfs\Uploader\Core\BaseFileModel
Jfs\Uploader\Core\Image
Jfs\Uploader\Core\Pdf
Jfs\Uploader\Core\Traits\FileCreationTrait
Jfs\Uploader\Core\Video
Jfs\Uploader\Enum\FileDriver
```

## Properties
- `protected $table = 'attachments'`
- `protected $casts = [...]`
- `protected $appends = ['file_type']`

## Methods with LOC > 5

| Method | LOC |
|--------|-----|
| getCategory | 12 |
| getView | 10 |
| getType | 16 |
| createFromScratch | 8 |
