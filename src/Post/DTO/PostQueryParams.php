<?php

namespace Module\Post\DTO;

use App\User;
class PostQueryParams
{
    public ?int $userId = null;
    public ?User $viewer = null;
    public ?string $mediaType = null;
    public ?string $sortBy = null;
    public ?string $sortOrder = null;
    public ?string $searchTerm = null;
    public int $page = 1;
    public ?int $perPage = null;
    public static function make(): self
    {
        throw new \RuntimeException();
    }
    public function forUser(int $userId): self
    {
        throw new \RuntimeException();
    }
    public function viewedBy(?User $viewer): self
    {
        throw new \RuntimeException();
    }
    public function withMediaType(?string $mediaType): self
    {
        throw new \RuntimeException();
    }
    public function withSortBy(?string $sortBy): self
    {
        throw new \RuntimeException();
    }
    public function withSortOrder(?string $sortOrder): self
    {
        throw new \RuntimeException();
    }
    public function withSearch(?string $searchTerm): self
    {
        throw new \RuntimeException();
    }
    public function page(int $page): self
    {
        throw new \RuntimeException();
    }
    public function perPage(int $perPage): self
    {
        throw new \RuntimeException();
    }
}
