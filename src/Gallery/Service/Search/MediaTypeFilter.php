<?php

namespace Jfs\Gallery\Service\Search;
use Jfs\Gallery\Service\Search\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class MediaTypeFilter implements FilterInterface
{
    public function apply(Builder $builder, $value, $dbValue): Builder
    {
        $types = is_array($value) ? $value : [$value];
        $filtered = array_filter($types, function ($t) {
            return is_string($t) && trim($t) !== '';
        });
        if (empty($filtered)) {
            return $builder;
        }
        if ($dbValue) {
            return $builder->whereIn('type', $filtered);
        }
        return $builder->whereNotIn('type', $filtered);
    }
}
