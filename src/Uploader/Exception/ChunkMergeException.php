<?php
declare(strict_types=1);

namespace Jfs\Uploader\Exception;

use Jfs\Uploader\Exception\UploadExceptionInterface;

class ChunkMergeException extends \Exception implements UploadExceptionInterface
{
    public function __construct(string $message = '', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
