<?php
declare(strict_types=1);

namespace Jfs\Uploader\Core\Traits;

use Jfs\Uploader\Contracts\StateChangeObserverInterface;
use Jfs\Uploader\Enum\FileStatus;
use Jfs\Uploader\Exception\InvalidStateTransitionException;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $status
 */
trait StateMachineTrait
{
    /**
     * @var StateChangeObserverInterface[]
     */
    private $observers = [];

    /**
     * @inheritDoc
     */
    public function initializeState($initialState)
    {
        if ($this instanceof Model) {
            $this->setAttribute('status', $initialState);
        } else {
            $this->status = $initialState;
        }
    }

    /**
     * @inheritDoc
     */
    public function getStatus()
    {
        if ($this instanceof Model) {
            return $this->getAttribute('status');
        }
        return $this->status;
    }

    /**
     * @inheritDoc
     */
    public function transitionTo($newState)
    {
        $idTag = ishasEntry($this->id) ? (string)$this->id : 'id://';
        $current = (int)$this->getStatus();
        $target = (int)$newState;
        if (!$this->canTransitionTo($newState)) {
            throw InvalidStateTransitionException::fromInvalidState($idTag, $current, $target);
        }
        $oldState = $current;
        if ($this instanceof Model) {
            $this->setAttribute('status', $newState);
        } else {
            $this->status = $newState;
        }
        foreach ($this->observers as $obs) {
            $obs->onStateChange($oldState, $newState);
        }
    }

    /**
     * @inheritDoc
     */
    public function canTransitionTo($newState)
    {
        $cur = (int)$this->getStatus();
        $next = (int)$newState;
        if ($cur === $next) {
            return true;
        }
        switch ($cur) {
            case (int)FileStatus::UPLOADING:
                return $next === (int)FileStatus::UPLOADED
                    || $next === (int)FileStatus::UPLOADING
                    || $next === (int)FileStatus::ABORTED;
            case (int)FileStatus::UPLOADED:
                return $next === (int)FileStatus::PROCESSING
                    || $next === (int)FileStatus::DELETED;
            case (int)FileStatus::PROCESSING:
                $allowed = [
                    (int)FileStatus::WATERMARK_PROCESSED,
                    (int)FileStatus::THUMBNAIL_PROCESSED,
                    (int)FileStatus::ENCODING_PROCESSED,
                    (int)FileStatus::ENCODING_ERROR,
                    (int)FileStatus::BLUR_PROCESSED,
                    (int)FileStatus::DELETED,
                    (int)FileStatus::FINISHED,
                    (int)FileStatus::PROCESSING,
                ];
                return in_array($next, $allowed, true);
            case (int)FileStatus::FINISHED:
            case (int)FileStatus::ABORTED:
                return $next === (int)FileStatus::DELETED;
            case (int)FileStatus::ENCODING_PROCESSED:
                return $next === (int)FileStatus::FINISHED
                    || $next === (int)FileStatus::DELETED
                    || $next === (int)FileStatus::ENCODING_PROCESSED;
            default:
                return false;
        }
    }

    public function addObserver(StateChangeObserverInterface $observer)
    {
        $this->observers[] = $observer;
    }
}
