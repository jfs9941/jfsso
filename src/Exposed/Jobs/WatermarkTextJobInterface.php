<?php

namespace Jfs\Exposed\Jobs;

interface WatermarkTextJobInterface
{
    public function putWatermark(string $id, string $username);
}
