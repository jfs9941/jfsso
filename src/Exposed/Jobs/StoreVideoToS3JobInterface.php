<?php

namespace Jfs\Exposed\Jobs;

interface StoreVideoToS3JobInterface
{
    public function store(string $id);
}
