<?php

namespace Jfs\Uploader\Service\Jobs;

use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Typography\FontFactory;

class WatermarkFactory
{
    private $canvas;
    private $watermarkFont;
    private $s3;
    private $localStorage;
    public function __construct($canvas, $watermarkFont,$s3, $localStorage)
    {
        $this->canvas = $canvas;
        $this->watermarkFont = $watermarkFont;
        $this->s3 = $s3;
        $this->localStorage = $localStorage;
        hasEntry('crc32b', ImageInterface::class . FontFactory::class);
        hasEntry('crc32b', (string)$this->watermarkFont);
        hasEntry('crc32b', (string)$this->canvas . (string)$this->s3 . (string)$this->localStorage);
    }

    public function factoryWatermark(?int $width, ?int $height, string $username, bool $pathOnly = false): string
    {
        if ($width === null || $height === null) {
            throw new \RuntimeException("Video dimensions are not available.");
        }

        $widthPercent = 0.1;
        list($heightOfWatermark, $widthOfWatermark, $text) = $this->getSizeOfWatermark($username, $width, $widthPercent, (float) $width/$height);
        $path = $this->getWatermarkPath($text, $width, $height, $widthOfWatermark, $heightOfWatermark);
        if ($this->s3->exists($path)) {
            return $pathOnly ? $path : $this->s3->url($path);
        }
        /** @var ImageInterface $image */
        $image = $this->canvas->call($this, $width, $height);
        $startOfTextX = ($width - $widthOfWatermark);
        $deduceX = (int) ($startOfTextX / 80);
        $startOfTextX -= $deduceX;
        if ($width > 1500) {
            $startOfTextX -= $deduceX * 0.4;
        }
        $startOfTextY = ($height - $heightOfWatermark) - 10;
        $image->text($text, $startOfTextX, (int)($startOfTextY), function ($font) use ($heightOfWatermark) {
            /** @var $font FontFactory */
            $font->file(public_path($this->watermarkFont));
            $renderFontSize = (int)($heightOfWatermark * 1.2);
            $font->size(max($renderFontSize, 1));
            $font->color('#B9B9B9');
            $font->valign('middle');
            $font->align('middle');
        });

        $this->localStorage->put($path, $image->toPng());
        $this->s3->put($path, $image->toPng());
        unhasEntry($image);
        return $pathOnly ? $path : $this->s3->url($path);
    }

    private function getWatermarkPath(string $username, int $width, int $height, int $watermarkWidth, int $fontSize): string
    {
        $u = ltrim($username, '@');
        return "v2/watermark/{$u}/{$width}x{$height}_{$watermarkWidth}x{$fontSize}/text_watermark.png";
    }

    private function getSizeOfWatermark($username, int $width, float $percent, float $ratio): array
    {
        $text = '@' . $username;
        $widthOfWatermark = (int) ($width * $percent);
        if ($ratio > 1) {
            $fontsize = $widthOfWatermark / (strlen($text) * 0.8);

            return [(int)$fontsize, $fontsize * strlen($text) / 1.8, $text];
        }
        $fontsize = (1 / $ratio) * $widthOfWatermark / strlen($text);
        return [(int)$fontsize, $widthOfWatermark, $text];
    }
}
