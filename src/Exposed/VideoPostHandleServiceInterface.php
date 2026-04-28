<?php
declare(strict_types=1);

namespace Jfs\Exposed;

interface VideoPostHandleServiceInterface
{
    public function saveMetadata(string $id, array $metadata);

    public function createThumbnail(string $uuid): void;

    public function getThumbnails(string $uuid): array;
    public function getMedia(string $uuid): array;
}
