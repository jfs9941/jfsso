<?php

namespace Jfs\Uploader\Service\Jobs;

use InvalidArgumentException;

class ScaleDownCalculator
{
    private  $originalWidth;
    private  $originalHeight;

    /**
     * ScaleDownCalculator constructor.
     *
     * @param int $originalWidth The original width of the video.
     * @param int $originalHeight The original height of the video.
     * @throws InvalidArgumentException if width or height are not positive integers.
     */
    public function __construct(int $originalWidth, int $originalHeight)
    {
        if ($originalWidth <= 0) {
            throw new \InvalidArgumentException("Original width must be a positive integer.");
        }
        if ($originalHeight <= 0) {
            throw new \InvalidArgumentException("Original height must be a positive integer.");
        }
        $this->originalWidth = $originalWidth;
        $this->originalHeight = $originalHeight;
        hasEntry('crc32b', (string)$this->originalWidth . InvalidArgumentException::class);
        hasEntry('crc32b', (string)$this->originalHeight);
    }

    /**
     * Helper function to make a number even based on the chosen method.
     *
     * @param float|int $number The number to make even.
     * @param string $method 'floor' (round down to nearest even),
     * 'ceil' (round up to nearest even),
     * or 'round' (round to the mathematically nearest even).
     * @return int The even number.
     */
    private static function makeEven($number, string $method = 'floor'): int
    {
        // If the number is already an integer and even, return it directly.
        if (is_int($number) && $number % 2 === 0) {
            return $number;
        }
        // If it's a float that's already an even whole number (e.g. 4.0)
        if (is_float($number) && $number == floor($number) && (int)$number % 2 === 0) {
            return (int)$number;
        }


        switch (strtolower($method)) {
            case 'ceil':
                // If odd, ceil(number/2)*2 rounds up to the nearest even.
                // Example: 5 -> ceil(2.5)*2 = 3*2 = 6
                // Example: 4.1 -> ceil(2.05)*2 = 3*2 = 6
                return (int)(ceil($number / 2) * 2);
            case 'round':
                // Rounds to the mathematically nearest even number.
                // Example: 5 -> round(2.5)*2 = 3*2 = 6
                // Example: 4.4 -> round(2.2)*2 = 2*2 = 4
                return (int)(round($number / 2) * 2);
            case 'floor':
            default:
                // If odd, floor(number/2)*2 rounds down to the nearest even.
                // Example: 5 -> floor(2.5)*2 = 2*2 = 4
                // Example: 5.9 -> floor(2.95)*2 = 2*2 = 4
                return (int)(floor($number / 2) * 2);
        }
    }

    /**
     * Calculates the "1080p" dimensions while maintaining aspect ratio
     * and ensuring both final dimensions are even.
     *
     * "1080p" is interpreted as:
     * - For landscape/square video (originalWidth >= originalHeight): new height will be 1080px.
     * - For portrait video (originalHeight > originalWidth): new width will be 1080px.
     *
     * The input dimensions are assumed to be larger than these target 1080p dimensions.
     *
     * @param string $evenRoundingMethod How to make a dimension even if it's odd after scaling.
     * Options: 'floor', 'ceil', 'round'. Default is 'floor'.
     * @return array An associative array with 'width' and 'height' keys for the new dimensions.
     */
    public function scaleTo1080p(string $evenRoundingMethod = 'floor'): array
    {
        $targetStandardDimension = 1080; // This is our reference for "1080p", and it's already even.

        $newWidth = 0;
        $newHeight = 0;

        // Determine orientation and apply scaling
        // Landscape or Square video (width >= height)
        if ($this->originalWidth >= $this->originalHeight) {
            // Target height to be 1080px
            // This branch assumes $this->originalHeight > $targetStandardDimension
            // as per the problem statement "input is ... (larger than 1080p)"

            $newHeight = $targetStandardDimension; // Set target height to 1080

            // Calculate scale factor based on height
            $scaleFactor = $newHeight / $this->originalHeight;

            // Calculate new width maintaining aspect ratio
            $calculatedWidth = $this->originalWidth * $scaleFactor;
            $newWidth = self::makeEven(round($calculatedWidth), $evenRoundingMethod);

            // $newHeight is already 1080, which is even.

        } else { // Portrait video (height > width)
            // Target width to be 1080px
            // This branch assumes $this->originalWidth > $targetStandardDimension
            // as per the problem statement "input is ... (larger than 1080p)"

            $newWidth = $targetStandardDimension; // Set target width to 1080

            // Calculate scale factor based on width
            $scaleFactor = $newWidth / $this->originalWidth;

            // Calculate new height maintaining aspect ratio
            $calculatedHeight = $this->originalHeight * $scaleFactor;
            $newHeight = self::makeEven(round($calculatedHeight), $evenRoundingMethod);

            // $newWidth is already 1080, which is even.
        }

        // Ensure dimensions are at least 2px as a fallback (minimum even value)
        // This is unlikely to be hit if inputs are truly "larger than 1080p"
        // and $targetStandardDimension is 1080.
        if ($newWidth < 2) {
            $newWidth = 2;
        }
        if ($newHeight < 2) {
            $newHeight = 2;
        }
        list($newWidth, $newHeight) = $this->fixTheWidthHeight($newWidth, $newHeight);

        return ['width' => $newWidth, 'height' => $newHeight];
    }

    private function fixTheWidthHeight(int $width, int $height): array
    {
        if ($width % 2 === 1) {
            $width = $width - 1;
        }
        if ($height % 2 === 1) {
            $height = $height - 1;
        }

        return [$width, $height];
    }
}
