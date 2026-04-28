<?php

declare (strict_types=1);
namespace Jfs\Uploader\Core;

use Jfs\Uploader\Core\P5VsoOIvgGpP2;
use Jfs\Uploader\Enum\Bx8RskyNfC1ZF;
use Illuminate\Database\Eloquent\Model;
abstract class Lt62r6cMmXzCB extends Model implements P5VsoOIvgGpP2
{
    public $incrementing = false;
    protected $fillable = ['user_id', 'filename', 'thumbnail', 'preview', 'type', 'id', 'driver', 'duration', 'status', 'parent_id', 'thumbnail_id', 'resolution', 'hls_path', 'fps', 'aws_media_converter_job_id', 'thumbnail_url', 'approved', 'stock_message_id', 'generated_previews'];
    protected $table = 'attachments';
    protected $casts = ['id' => 'string', 'generated_previews' => 'array', 'driver' => 'int', 'status' => 'int'];
    public function mJtsIBGrcJE(): bool
    {
        return false;
    }
    protected function msgWaXasfWa(): bool
    {
        return false;
    }
    abstract public function getView(): array;
}
