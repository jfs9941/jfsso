# Jfs\Gallery\Service\MediaSearchService

**File:** `smoke/Gallery/Service/MediaSearchService.php`

## Use Statements
```php
Jfs\Exposed\GalleryCloudInterface
Jfs\Gallery\Model\Cloud
Jfs\Gallery\Model\Enum\StatusEnum
Jfs\Gallery\Model\Media
Jfs\Gallery\Service\Search\CategoryFilter
Jfs\Gallery\Service\Search\FilterInterface
Jfs\Gallery\Service\Search\MediaTypeFilter
Illuminate\Database\Eloquent\Builder
Illuminate\Support\Facades\DB
```

## Properties
- `private $filterMap = ['types' => MediaTypeFilter::class, 'category' => CategoryFilter::class]`

## Methods with LOC > 5

| Method | LOC |
|--------|-----|
| search | 43 |
| searchBuilders | 21 |
| saveItems | 9 |
