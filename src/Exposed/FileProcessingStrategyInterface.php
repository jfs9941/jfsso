<?php
declare(strict_types=1);

namespace Jfs\Exposed;

interface FileProcessingStrategyInterface
{
    public function process(int $toStatus);
}
