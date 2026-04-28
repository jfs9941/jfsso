<?php
declare(strict_types=1);

namespace Jfs\Uploader\Contracts;

interface StateChangeObserverInterface
{
    /**
     * @param int $fromState
     * @param int $toState
     * Handle state change from one state to another
     */
    public function onStateChange($fromState, $toState);
}
