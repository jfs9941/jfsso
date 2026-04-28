<?php

namespace Module\Post\Query\Concerns;

use App\Providers\AttachmentServiceProvider;
use Illuminate\Database\Eloquent\Builder;
trait FiltersMediaType
{
    protected function filterByMediaType(Builder $query, ?string $mediaType): void
    {
    }
}
