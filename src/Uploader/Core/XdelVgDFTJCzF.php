<?php

declare (strict_types=1);
namespace Jfs\Uploader\Core;

use Jfs\Uploader\Core\C9FHXGvl3C2AZ;
use Jfs\Uploader\Enum\O4vZ2Z4FeMOYj;
use Illuminate\Database\Eloquent\Model;
abstract class XdelVgDFTJCzF extends Model implements C9FHXGvl3C2AZ
{
    public $incrementing = false;
    protected $fillable = ['user_id', 'filename', 'thumbnail', 'preview', 'type', 'id', 'driver', 'duration', 'status', 'parent_id', 'thumbnail_id', 'resolution', 'hls_path', 'fps', 'aws_media_converter_job_id', 'thumbnail_url', 'approved', 'stock_message_id', 'generated_previews'];
    protected $table = 'attachments';
    protected $casts = ['id' => 'string', 'generated_previews' => 'array', 'driver' => 'int', 'status' => 'int'];
    public function mG3MzFBpml0(): bool
    {
        return false;
    }
    protected function mrkvxRpMjpr(): bool
    {
        return false;
    }
    abstract public function getView(): array;
}
