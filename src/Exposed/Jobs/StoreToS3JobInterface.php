<?php

namespace Jfs\Exposed\Jobs;

interface StoreToS3JobInterface
{
    public function store(string $id): void;
}
