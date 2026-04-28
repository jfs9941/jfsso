<?php
declare(strict_types=1);

namespace Jfs\Uploader\Exception;

use Jfs\Uploader\Exception\UploadExceptionInterface;

class InvalidTempFileException extends \Exception implements UploadExceptionInterface
{
}
