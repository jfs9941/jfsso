<?php

declare (strict_types=1);
namespace Jfs\Providers;

use Aws\MediaConvert\MediaConvertClient;
use Jfs\Exposed\GalleryCloudInterface;
use Jfs\Exposed\Jobs\BlurJobInterface;
use Jfs\Exposed\Jobs\BlurVideoJobInterface;
use Jfs\Exposed\Jobs\CompressJobInterface;
use Jfs\Exposed\Jobs\DownloadToLocalJobInterface;
use Jfs\Exposed\Jobs\GenerateImageVersionsFromPathJobInterface;
use Jfs\Exposed\Jobs\GenerateImageVersionsJobInterface;
use Jfs\Exposed\Jobs\GenerateThumbnailJobInterface;
use Jfs\Exposed\Jobs\MediaEncodeJobInterface;
use Jfs\Exposed\Jobs\PrepareMetadataJobInterface;
use Jfs\Exposed\Jobs\StoreToS3JobInterface;
use Jfs\Exposed\Jobs\StoreVideoToS3JobInterface;
use Jfs\Exposed\Jobs\WatermarkTextJobInterface;
use Jfs\Exposed\UploadServiceInterface;
use Jfs\Exposed\VideoPostHandleServiceInterface;
use Jfs\Gallery\Service\EHgJctTBt6rFW;
use Jfs\Uploader\Contracts\C93eDyeNXEenk;
use Jfs\Uploader\Encoder\MsA36KFH9POAI;
use Jfs\Uploader\Encoder\ADDHvHRQEuyCb;
use Jfs\Uploader\Service\XwmQt5GM35s4u;
use Jfs\Uploader\Service\FileResolver\RCtGGSAvhAFYB;
use Jfs\Uploader\Service\FileResolver\FafYhZFWB7Rgz;
use Jfs\Uploader\Service\FileResolver\VoZNmIAR1ZjzE;
use Jfs\Uploader\Service\Jobs\XUy0D6Hg1yhfQ;
use Jfs\Uploader\Service\Jobs\KEXUDEFKoV8V1;
use Jfs\Uploader\Service\Jobs\SPjuK0ZiiAOfy;
use Jfs\Uploader\Service\Jobs\J0GLtdNKQAw0s;
use Jfs\Uploader\Service\Jobs\Wx7VOghQe3guO;
use Jfs\Uploader\Service\Jobs\AlRIqJMvjcZiK;
use Jfs\Uploader\Service\Jobs\DuH6jkB5hpbZc;
use Jfs\Uploader\Service\Jobs\NqptcOw8KXF8n;
use Jfs\Uploader\Service\Jobs\VHOWVZl7LLj5z;
use Jfs\Uploader\Service\Jobs\QRNAed2QEeijZ;
use Jfs\Uploader\Service\Jobs\LTbaIsLmm0GMC;
use Jfs\Uploader\Service\Jobs\E1WMBZNuvpMVd;
use Jfs\Uploader\Service\TK7hMURkTBQP2;
use Jfs\Uploader\Service\ZqJfFm114v8uj;
use Jfs\Uploader\Service\F48xYuwdbU9ak;
use Jfs\Uploader\Service\XcXvB8TL1zl4c;
use Illuminate\Filesystem\AwsS3V3Adapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
class UploadServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }
    public function boot(): void
    {
    }
}
