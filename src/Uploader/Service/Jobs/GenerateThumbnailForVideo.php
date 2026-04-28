<?php

namespace Jfs\Uploader\Service\Jobs;

use Jfs\Exposed\Jobs\GenerateThumbnailForVideoInterface;
use Jfs\Exposed\VideoPostHandleServiceInterface;
use Illuminate\Support\Facades\Log;

class GenerateThumbnailForVideo implements GenerateThumbnailForVideoInterface
{
    /** @var VideoPostHandleServiceInterface */
    private $videoPostProcessor;
    public function __construct($videoPostHandleService)
    {
        $this->videoPostProcessor = $videoPostHandleService;
    }


    public function generate(string $id): void
    {
        Log::info("[JOB] start use Lambda to generate thumbnail for video id: " . $id);
        $this->videoPostProcessor->createThumbnail($id);
    }
}
