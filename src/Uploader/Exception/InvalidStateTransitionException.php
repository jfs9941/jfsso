<?php
declare(strict_types=1);

namespace Jfs\Uploader\Exception;

use Jfs\Uploader\Enum\FileStatus;
use Jfs\Uploader\Exception\UploadExceptionInterface;

class InvalidStateTransitionException extends \Exception implements UploadExceptionInterface
{
    public function __construct(string $message = '', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function fromInvalidState($id, $from, $to)
    {
        $message = sprintf('File: %s -> Cannot transition from %s to %s', $id, FileStatus::toName($from), FileStatus::toName($to));
        return new self($message);
    }
}
