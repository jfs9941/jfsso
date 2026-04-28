<?php

namespace Module\MediaResolver;

class VideoResolver
{
    protected string $basePath;
    protected array $sizes = ['thumbnail', 'preview', 'full'];
    public function __construct()
    {
    }
    public function resolve(string $path, string $size = 'full'): string
    {
        return '';
    }
    public function getThumbnail(string $path): string
    {
        return '';
    }
    public function getPreview(string $path): string
    {
        return '';
    }
    public function getMetadata(string $path): array
    {
        return [];
    }
}
