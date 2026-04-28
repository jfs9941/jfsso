<?php

declare (strict_types=1);
namespace Jfs\Uploader\Core;

use Jfs\Uploader\Core\SyRXKGwdiTYAi;
use Jfs\Uploader\Enum\ZgzpArDjoQn9x;
use Illuminate\Database\Eloquent\Model;
abstract class NNzaQAbr5K79S extends Model implements SyRXKGwdiTYAi
{
    public $incrementing = false;
    protected $fillable = ['user_id', 'filename', 'thumbnail', 'preview', 'type', 'id', 'driver', 'duration', 'status', 'parent_id', 'thumbnail_id', 'resolution', 'hls_path', 'fps', 'aws_media_converter_job_id', 'thumbnail_url', 'approved', 'stock_message_id', 'generated_previews'];
    protected $table = 'attachments';
    protected $casts = ['id' => 'string', 'generated_previews' => 'array', 'driver' => 'int', 'status' => 'int'];
    public function mMDn1E0xlyM(): bool
    {
        return false;
    }
    protected function mJrSvmZFvEv(): bool
    {
        return false;
    }
    abstract public function getView(): array;
}
