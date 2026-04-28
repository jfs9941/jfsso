<?php

namespace Jfs\Gallery\Model;

use Jfs\Gallery\Model\Enum\StatusEnum;
use Jfs\Gallery\Model\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cloud extends Model
{
    protected $table = 'cloud';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'user_id',
        'status',
        'is_post',
        'is_shop',
        'is_message',
        'type'
    ];

    protected $casts = [
        'id' => 'string',
        'user_id' => 'integer',
        'status' => 'int',
        'is_post' => 'boolean',
        'is_shop' => 'boolean',
        'is_message' => 'boolean',
    ];

    public function media(): HasOne
    {
        return $this->hasOne(Media::class, 'id','id');
    }

    public function getMedia()
    {
        return $this->media;
    }

    public static function createFromMedia(Media $media, $enum = StatusEnum::APPROVED): void
    {
    }

}
