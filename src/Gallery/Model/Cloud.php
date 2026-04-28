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
    protected $fillable = ['id', 'user_id', 'status', 'is_post', 'is_shop', 'is_message', 'type'];
    protected $casts = ['id' => 'string', 'user_id' => 'integer', 'status' => 'int', 'is_post' => 'boolean', 'is_shop' => 'boolean', 'is_message' => 'boolean'];
    public function media(): HasOne
    {
        throw new \RuntimeException();
    }
    public function getMedia()
    {
        return null;
    }
    public static function msvUqfHa7IO(Media $PPwbn, $LSTKE = StatusEnum::I2fNI): void
    {
    }
}
