<?php

namespace Jfs\Gallery\Service\Search;
use Illuminate\Database\Eloquent\Builder;

interface FilterInterface
{
    public function apply(Builder $builder, $value, $dbValue): Builder;
}
