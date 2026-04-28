<?php

namespace Jfs\Gallery\Model;

use Jfs\Gallery\Model\Enum\MediaTypeEnum;
use Jfs\Uploader\Core\IHzJNfmh495oE;
use Jfs\Uploader\Core\KAa6CFNxPLqgb;
use Jfs\Uploader\Core\GVVxpgt8mKKel;
use Jfs\Uploader\Core\Traits\UZcWSDgh5UASY;
use Jfs\Uploader\Core\ZLRWBheXxxPEB;
use Jfs\Uploader\Enum\UofpWGItNtNLo;
class Media extends IHzJNfmh495oE
{
    use UZcWSDgh5UASY;
    protected $table = 'attachments';
    protected $casts = ['driver' => 'int', 'id' => 'string', 'approved' => 'boolean'];
    protected $appends = ['file_type'];
    public function maOyGNrmMBO(): string
    {
        return '';
    }
    public function getView(): array
    {
        return [];
    }
    public function getType(): string
    {
        return '';
    }
    public static function createFromScratch(string $rDggW, string $CamM1): \Jfs\Gallery\Model\Media
    {
        throw new \RuntimeException();
    }
}
