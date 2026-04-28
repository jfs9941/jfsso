<?php
declare(strict_types=1);

namespace Jfs\Uploader\Core\Traits;

trait WatermarkTrait
{
    private function getWatermarkText(string $username): string
    {
        return str_replace(['https://', 'http://', 'www.'], '', route('profile', ['username' => $username]));
    }
}
