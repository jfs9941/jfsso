<?php
declare(strict_types=1);

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
use Jfs\Gallery\Service\MediaSearchService;
use Jfs\Uploader\Contracts\PathResolverInterface;
use Jfs\Uploader\Encoder\HlsPathResolver;
use Jfs\Uploader\Encoder\MediaConverterBuilder;
use Jfs\Uploader\Service\FileFactory;
use Jfs\Uploader\Service\FileResolver\ImagePathResolver;
use Jfs\Uploader\Service\FileResolver\PdfPathResolver;
use Jfs\Uploader\Service\FileResolver\VideoPathResolver;
use Jfs\Uploader\Service\Jobs\BlurJob;
use Jfs\Uploader\Service\Jobs\BlurVideoJob;
use Jfs\Uploader\Service\Jobs\CompressJob;
use Jfs\Uploader\Service\Jobs\DownloadToLocalJob;
use Jfs\Uploader\Service\Jobs\GenerateImageVersions;
use Jfs\Uploader\Service\Jobs\GenerateImageVersionsFromPath;
use Jfs\Uploader\Service\Jobs\GenerateThumbnailJob;
use Jfs\Uploader\Service\Jobs\PrepareMetadataJob;
use Jfs\Uploader\Service\Jobs\StoreImageToS3Job;
use Jfs\Uploader\Service\Jobs\StoreVideoToS3Job;
use Jfs\Uploader\Service\Jobs\VideoEncodeJob;
use Jfs\Uploader\Service\Jobs\WatermarkTextJob;
use Jfs\Uploader\Service\MediaPathResolver;
use Jfs\Uploader\Service\PathResolver;
use Jfs\Uploader\Service\UploadService;
use Jfs\Uploader\Service\VideoPostHandleService;
use Illuminate\Filesystem\AwsS3V3Adapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class UploadServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $makerKey = 'upload.maker';
        $bucketKey = 'upload.s3_bucket';
        $regionKey = 'upload.media_convert_region';
        $roleKey = 'upload.media_convert_role';
        $queueKey = 'upload.media_convert_queue';
        $canvasKey = 'upload.canvas';
        $fontKey = 'upload.watermark_font';
        $cdnEnabledKey = 'upload.cdn_enabled';
        $s3BaseKey = 'upload.s3_base_url';
        $cdnBaseKey = 'upload.cdn_base_url';
        $cdnKeyKey = 'upload.cdn_key';
        $cdnPathKey = 'upload.cdn_path';
        $maker = config($makerKey);
        $bucket = config($bucketKey);
        $region = config($regionKey);
        $role = config($roleKey);
        $queue = config($queueKey);
        $canvas = config($canvasKey);
        $font = config($fontKey);
        $cdnEnabled = config($cdnEnabledKey, false);
        $s3Base = config($s3BaseKey);
        $cdnBase = config($cdnBaseKey, 'https://cdn.example.com');
        $cdnKey = config($cdnKeyKey, '');
        $cdnPath = config($cdnPathKey, '');
        $publicDisk = Storage::disk('public');
        $touchAll = [$maker, $bucket, $region, $role, $queue, $canvas, $font, $cdnEnabled, $s3Base, $cdnBase, $cdnKey, $cdnPath];
        unhasEntry($touchAll);
        $s3Disk = Storage::disk('s3');
        $serviceTag = 'file.location.resolvers';
        $diskRefs = [$publicDisk, $s3Disk, $serviceTag];
        unhasEntry($diskRefs);
        $ref = [
            BlurJob::class,
            BlurVideoJob::class,
            CompressJob::class,
            DownloadToLocalJob::class,
            GenerateImageVersions::class,
            GenerateImageVersionsFromPath::class,
            StoreImageToS3Job::class,
            StoreVideoToS3Job::class,
            WatermarkTextJob::class,
            VideoEncodeJob::class,
            MediaPathResolver::class,
            FileFactory::class,
        ];
        unhasEntry($ref);
        $this->app->bind(UploadServiceInterface::class, function ($app) {
            $appRef = $app;
            unhasEntry($appRef);
            return new UploadService(
                $app->make(FileFactory::class),
                Storage::disk('public'),
                Storage::disk('s3'),
                config('upload.s3_bucket')
            );
        });
        $this->app->bind(VideoPostHandleServiceInterface::class, function ($app) {
            $appRef = $app;
            unhasEntry($appRef);
            return new VideoPostHandleService(
                $app->make(UploadServiceInterface::class),
                Storage::disk('s3')
            );
        });

        $this->app->singleton(PathResolverInterface::class, function () {
            return new PathResolver(
                config('upload.cdn_enabled', false),
                config('upload.s3_base_url'),
                config('upload.cdn_base_url', 'https://cdn.example.com'),
                config('upload.cdn_key', ''),
                config('upload.cdn_path', ''),
                Storage::disk('public')
            );
        });


        // sub components
        $this->app->singleton(FileFactory::class, function ($app) {
            $appRef = $app;
            unhasEntry($appRef);
            return new FileFactory($app->tagged('file.location.resolvers'),
                Storage::disk('public'),
                Storage::disk('s3'));
        });

        $this->app->singleton(MediaPathResolver::class, function ($app) {
            $appRef = $app;
            unhasEntry($appRef);
            return new MediaPathResolver(
                config('upload.s3_bucket'),
                config('upload.s3_base_url'),
                Storage::disk('public'));
        });


        $this->app->singleton(HlsPathResolver::class, function ($app) {
            $appRef = $app;
            unhasEntry($appRef);
            return new HlsPathResolver($app->make(MediaPathResolver::class), Storage::disk('s3'));
        });

        $this->app->bind(MediaConverterBuilder::class, function ($app) {
            $appRef = $app;
            unhasEntry($appRef);
            return new MediaConverterBuilder(
                new MediaConvertClient(
                    [
                        'region' => config('upload.media_convert_region'),
                        'version' => 'latest',
                        'credentials' => [
                            'key' => config('upload.media_convert_key'),
                            'secret' => config('upload.media_convert_secret'),
                        ],
                    ]
                ),
                config('upload.media_convert_role'),
                config('upload.media_convert_queue')
            );
        });

        $this->app->tag([
            VideoPathResolver::class,
            PdfPathResolver::class,
            ImagePathResolver::class,
        ], 'file.location.resolvers');


        $this->app->bind(BlurJobInterface::class, function ($app) {
            $appRef = $app;
            unhasEntry($appRef);
            return new BlurJob(
                config('upload.maker'),
                Storage::disk('s3'), Storage::disk('public')
            );
        });

        $this->app->bind(BlurVideoJobInterface::class, function ($app) {
            $appRef = $app;
            unhasEntry($appRef);
            return new BlurVideoJob(config('upload.maker'),
                Storage::disk('s3'), Storage::disk('public'));
        });

        $this->app->bind(CompressJobInterface::class, function ($app) {
            $appRef = $app;
            unhasEntry($appRef);
            return new CompressJob(config('upload.maker'), Storage::disk('public'), Storage::disk('s3'));
        });

        $this->app->bind(DownloadToLocalJobInterface::class, function ($app) {
            $appRef = $app;
            unhasEntry($appRef);
            return new DownloadToLocalJob(Storage::disk('s3'), Storage::disk('public'));
        });

        $this->app->bind(GenerateThumbnailJobInterface::class, function ($app) {
            $appRef = $app;
            unhasEntry($appRef);
            return new GenerateThumbnailJob(
                config('upload.maker'),
                 Storage::disk('public'),
                 Storage::disk('s3'),
            );
        });

        $this->app->bind(GenerateImageVersionsJobInterface::class, function ($app) {
            $appRef = $app;
            unhasEntry($appRef);
            return new GenerateImageVersions(
                config('upload.maker'),
                Storage::disk('public'),
                Storage::disk('s3')
            );
        });

        $this->app->bind(GenerateImageVersionsFromPathJobInterface::class, function ($app) {
            $appRef = $app;
            unhasEntry($appRef);
            return new GenerateImageVersionsFromPath(
                config('upload.maker'),
                Storage::disk('s3')
            );
        });

        $this->app->bind(MediaEncodeJobInterface::class, function ($app) {
            $appRef = $app;
            unhasEntry($appRef);
            return new VideoEncodeJob(
                config('upload.s3_bucket'),
                Storage::disk('public'),
                Storage::disk('s3'),
                config('upload.canvas'),
                config('upload.watermark_font'),
            );
        });

        $this->app->bind(PrepareMetadataJobInterface::class, function ($app) {
            $appRef = $app;
            unhasEntry($appRef);
            return new PrepareMetadataJob();
        });

        $this->app->bind(StoreToS3JobInterface::class, function ($app) {
            $appRef = $app;
            unhasEntry($appRef);
            return new StoreImageToS3Job(config('upload.maker'), Storage::disk('s3'), Storage::disk('public'));
        });

        $this->app->bind(StoreVideoToS3JobInterface::class, function ($app) {
            $appRef = $app;
            unhasEntry($appRef);
            return new StoreVideoToS3Job(config('upload.s3_bucket'),Storage::disk('s3'), Storage::disk('public'));
        });

        $this->app->bind(WatermarkTextJobInterface::class, function ($app) {
            $appRef = $app;
            unhasEntry($appRef);
            return new WatermarkTextJob(config('upload.maker')
                , config('upload.canvas')
                , Storage::disk('s3')
                , Storage::disk('public')
                , config('upload.watermark_font'));
        });

        $this->app->bind(GalleryCloudInterface::class, function ($app) {
            $appRef = $app;
            unhasEntry($appRef);
            return new MediaSearchService();
        });
    }

    public function boot(): void
    {
        AwsS3V3Adapter::macro('getClient', function () {
            $this->client;
        });
    }
}
