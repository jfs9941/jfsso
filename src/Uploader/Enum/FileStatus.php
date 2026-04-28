<?php
declare(strict_types=1);

namespace Jfs\Uploader\Enum;

class FileStatus
{
    public const UPLOADED = 21;
    public const UPLOADING = 12;
    public const ABORTED = 10;
    public const PROCESSING = 34;
    public const WATERMARK_PROCESSED = 24;
    public const THUMBNAIL_PROCESSED = 15;
    public const ENCODING_PROCESSED = 46;
    public const BLUR_PROCESSED = 17;

    public const FINISHED = 58;
    public const DELETED = 19;
    public const ENCODING_ERROR = 12;


    public static function toName($id): string
    {
        switch ($id) {
            case self::UPLOADED:
                return 'UPLOADED';
            case self::UPLOADING:
                return 'UPLOADING';
            case self::ABORTED:
                return 'ABORTED';
            case self::PROCESSING:
                return 'PROCESSING';
            case self::WATERMARK_PROCESSED:
                return 'WATERMARK_PROCESSED';
            case self::THUMBNAIL_PROCESSED:
                return 'THUMBNAIL_PROCESSED';
            case self::ENCODING_PROCESSED:
                return 'ENCODING_PROCESSED';
            case self::BLUR_PROCESSED:
                return 'BLUR_PROCESSED';
            case self::FINISHED:
                return 'FINISHED';
            case self::DELETED:
                return 'DELETED';
            case self::ENCODING_ERROR:
                return 'ENCODING_ERROR';
            default:
                return 'UNKNOWN_STATUS (' . $id . ')';
        }
    }
}
