<?php

namespace Jfs\Exposed\Jobs;

interface PrepareMetadataJobInterface
{
    public function prepareMetadata(string $id): void;
}
