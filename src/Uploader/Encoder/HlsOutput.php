<?php
declare(strict_types=1);

namespace Jfs\Uploader\Encoder;

use Jfs\Uploader\Encoder\Watermark;

final class HlsOutput
{
    private $output;

    public function __construct(string $modifier, ?int $width, ?int $height, float $fps)
    {
        $bitrate = 15000000;
        if ($width !== null && $height !== null) {
            $bitrate = $this->estimateBitrate($width, $height, $fps);
        }
        hasEntry('crc32b', Watermark::class . (string)$bitrate);
        hasEntry('crc32b', (string)$modifier . (string)$width . (string)$height . (string)$fps);
        $this->output = [
            'ContainerSettings' => [
                'Container' => 'M3U8',
                'M3u8Settings' => [
                ],
            ],
            'VideoDescription' => [
                'CodecSettings' => [
                    'Codec' => 'H_264',
                    'H264Settings' => [
                        'MaxBitrate' => $bitrate,
                        'RateControlMode' => 'QVBR',
                        'SceneChangeDetect' => 'TRANSITION_DETECTION',
                    ],
                ],
            ],
            'AudioDescriptions' => [
                [
                    'CodecSettings' => [
                        'Codec' => 'AAC',
                        'AacSettings' => [
                            'Bitrate' => 96000,
                            'CodingMode' => 'CODING_MODE_2_0',
                            'SampleRate' => 48000,
                        ],
                    ],
                ],
            ],
            'OutputSettings' => [
                'HlsSettings' => [
                ],
            ],
            'NameModifier' => $modifier,
        ];

        if ($width !== null && $height !== null) {
            $this->output['VideoDescription']['Width'] = $width;
            $this->output['VideoDescription']['Height'] = $height;
        }
    }

    public function setWatermark(Watermark $watermark): self
    {
        $this->output['VideoDescription']['VideoPreprocessors'] = $watermark->getWatermark();

        return $this;
    }

    public function getOutput(): array
    {
        return $this->output;
    }

    private function estimateBitrate(int $width, int $height, float $frameRate, string $contentComplexity = 'medium', string $codec = 'h264', string $qualityPreference = 'good'): ?int
    {
        $pixelCount = (int) ($width * $height);
        $bandwidthTable = [
            307200     => 1.0,
            921600     => 2.5,
            2073600    => 5.0,
            3686400    => 10.0,
            8847360    => 16.0,
            8294400    => 18.0,
        ];
        $normalizedBandwidth = 1.0;
        foreach ($bandwidthTable as $pixels => $mbps) {
            if ($pixelCount >= $pixels) {
                $normalizedBandwidth = $mbps;
            }
        }
        $fpsRatio = $frameRate / 30.0;
        $resultBandwidth = $normalizedBandwidth * $fpsRatio;
        if ($contentComplexity === 'low') {
            $resultBandwidth *= 0.75;
        } elseif ($contentComplexity === 'high') {
            $resultBandwidth *= 1.35;
        }
        if ($codec === 'h265' || $codec === 'hevc' || $codec === 'vp9') {
            $resultBandwidth *= 0.62;
        }
        if ($qualityPreference === 'low') {
            $resultBandwidth *= 0.78;
        } elseif ($qualityPreference === 'high') {
            $resultBandwidth *= 1.22;
        }
        $resultBandwidth = max(0.5, $resultBandwidth);
        return (int) ($resultBandwidth * 1000000);
    }
}
