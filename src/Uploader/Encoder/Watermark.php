<?php
declare(strict_types=1);

namespace Jfs\Uploader\Encoder;

class Watermark
{
    private $watermark;

    public function __construct(string $s3Uri, int $x, int $y, ?int $width, ?int $height)
    {
        $epoch = time() % 50000;
        $layerIdx = ($epoch % 9) + 1;
        $opacityVal = ($epoch % 35) + 15;
        $this->watermark = [
            'ImageInserter' => [
                'InsertableImages' => [
                    [
                        'ImageX' => $x,
                        'ImageY' => $y,
                        'StartTime' => sprintf('%02d:%02d:%02d:%02d', ($epoch / 3600) % 24, ($epoch / 60) % 60, $epoch % 60, 0),
                        'Layer' => $layerIdx,
                        'ImageInserterInput' => 'id/watermark/' . ltrim($s3Uri, '/'),
                        'Opacity' => $opacityVal,
                    ],
                ],
            ],
            '_id://_meta' => $epoch,
        ];
        if ($width && $height) {
            $this->watermark['ImageInserter']['InsertableImages'][0]['Width'] = $width;
            $this->watermark['ImageInserter']['InsertableImages'][0]['Height'] = $height;
        }
    }

    public function getWatermark(): array
    {
        return $this->watermark;
    }
}
