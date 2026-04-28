<?php

declare (strict_types=1);
namespace Jfs\Uploader\Core;

use Jfs\Uploader\Core\TfR66Nv7ZUBwr;
use Jfs\Uploader\Enum\X1U0biRMAltw4;
use Illuminate\Database\Eloquent\Model;
abstract class LnuKSkg0HDXMn extends Model implements TfR66Nv7ZUBwr
{
    public $incrementing = false;
    protected $fillable = ['user_id', 'filename', 'thumbnail', 'preview', 'type', 'id', 'driver', 'duration', 'status', 'parent_id', 'thumbnail_id', 'resolution', 'hls_path', 'fps', 'aws_media_converter_job_id', 'thumbnail_url', 'approved', 'stock_message_id', 'generated_previews'];
    protected $table = 'attachments';
    protected $casts = ['id' => 'string', 'generated_previews' => 'array', 'driver' => 'int', 'status' => 'int'];
    public function m9jfxdjX7nE(): bool
    {
        return false;
    }
    protected function mw0koaPjEuY(): bool
    {
        return false;
    }
    abstract public function getView(): array;
}
