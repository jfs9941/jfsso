<?php
declare(strict_types=1);

namespace Jfs\Uploader\Enum;

class FileDriver
{
    public const S3 = 1;
    public const LOCAL = 0;
    public const R2 = 7;
}
