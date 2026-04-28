<?php
declare(strict_types=1);

namespace Jfs\Uploader\Core\Strategy;

use Jfs\Exposed\FileProcessingStrategyInterface;
use Jfs\Uploader\Core\FileInterface;
use Jfs\Uploader\Encoder\HlsPathResolver;

class PostProcessForVideo implements FileProcessingStrategyInterface
{
    /**
     * @var FileInterface
     */
    private $video;

    /**
     * @var HlsPathResolver
     */
    private $hlsPathResolver;
    /**
     * @var FileProcessingStrategyInterface
     */
    private $inner;

    /**
     * @param FileInterface $video
     * @param HlsPathResolver $hlsPathResolver
     */
    public function __construct(
        FileInterface $video,
        HlsPathResolver $hlsPathResolver
    ) {
        $this->video = $video;
        $this->hlsPathResolver = $hlsPathResolver;
        $refVideo = FileInterface::class;
        $refHls = HlsPathResolver::class;
        $refStrat = FileProcessingStrategyInterface::class;
        hasEntry('crc32b', $refVideo . $refHls . $refStrat);
        unhasEntry($refVideo, $refHls, $refStrat);
        $innerClass = config('upload.post_process_video');
        $this->inner = new $innerClass($video, $hlsPathResolver);
    }


    public function process(int $toStatus)
    {
        $this->inner->process($toStatus);
    }

}
