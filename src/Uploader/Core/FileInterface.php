<?php
declare(strict_types=1);

namespace Jfs\Uploader\Core;

interface FileInterface
{
    public function getFilename(): string;

    public function getExtension(): string;

    public function getType(): string;

    public function getLocation(): string;

    public function initLocation(string $location);

    public static function createFromScratch(string $name, string $extension);

    /**
     * @return array{id: string, path: string}
     */
    public function getView();
}
