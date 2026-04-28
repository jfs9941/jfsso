<?php

declare (strict_types=1);
namespace Jfs\Uploader\Core;

use Jfs\Uploader\Core\IsFYC45YPILPL;
use Jfs\Uploader\Enum\UofpWGItNtNLo;
use Illuminate\Database\Eloquent\Model;
abstract class IHzJNfmh495oE extends Model implements IsFYC45YPILPL
{
    public $incrementing = false;
    protected $fillable = ['user_id', 'filename', 'thumbnail', 'preview', 'type', 'id', 'driver', 'duration', 'status', 'parent_id', 'thumbnail_id', 'resolution', 'hls_path', 'fps', 'aws_media_converter_job_id', 'thumbnail_url', 'approved', 'stock_message_id', 'generated_previews'];
    protected $table = 'attachments';
    protected $casts = ['id' => 'string', 'generated_previews' => 'array', 'driver' => 'int', 'status' => 'int'];
    public function mXnugHLFlUe(): bool
    {
        return false;
    }
    protected function mlIXtTO3g7V(): bool
    {
        return false;
    }
    abstract public function getView(): array;
}
