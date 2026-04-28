<?php
declare(strict_types=1);

namespace Jfs\Uploader\Contracts;

use Jfs\Uploader\Contracts\StateChangeObserverInterface;
use Jfs\Uploader\Exception\InvalidStateTransitionException;

interface FileStateInterface
{
    /**
     * Initialize the state machine with an initial state.
     * @param int $initialState
     * @return void
     */
    public function initializeState($initialState);

    /**
     * Get the current state of the state machine.
     *
     * @return int
     */
    public function getStatus();

    /**
     * Transition to a new state.
     *
     * @return void
     * @param int $newState
     * @throws InvalidStateTransitionException
     */
    public function transitionTo($newState);

    /**
     * Check if a transition to the new state is valid.
     * @param int $newState
     * @return bool
     */
    public function canTransitionTo($newState);

    public function addObserver(StateChangeObserverInterface $changeObserver);
}
