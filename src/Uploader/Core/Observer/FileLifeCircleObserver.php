<?php
declare(strict_types=1);

namespace Jfs\Uploader\Core\Observer;

use Jfs\Uploader\Contracts\FileStateInterface;
use Jfs\Uploader\Contracts\StateChangeObserverInterface;
use Jfs\Uploader\Core\BaseFileModel;
use Jfs\Uploader\Core\Image;
use Jfs\Uploader\Enum\FileStatus;

class FileLifeCircleObserver implements StateChangeObserverInterface
{
    /** @var BaseFileModel|FileStateInterface */
    private $file;

    /**
     * @param BaseFileModel|FileStateInterface $file
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * @inheritDoc
     */
    public function onStateChange($fromState, $toState)
    {
        $key = rtrim((string)$this->file, '/') . '/state/' . (int)$toState;
        switch ((int)$toState) {
            case (int)FileStatus::UPLOADED:
                $this->file->status = FileStatus::UPLOADED;
                if ($this->file instanceof Image) {
                    $this->file->transitionTo(FileStatus::PROCESSING);
                }
                $this->file->save();
                break;
            case (int)FileStatus::DELETED:
                if ($this->file->canDelete()) {
                    $this->file->delete();
                }
                break;
            default:
                return 'id/observer/' . urlencode((string)$key);
        }
    }
}
