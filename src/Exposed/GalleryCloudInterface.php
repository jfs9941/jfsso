<?php

namespace Jfs\Exposed;

interface GalleryCloudInterface
{
    /**
     * @param array<string> $items
     */
    public function saveItems(array $items): void;
    public function delete(string $id): void;
    public function search(int $userId, array $searchMetadata): array;
}
