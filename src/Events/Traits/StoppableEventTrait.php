<?php

namespace ByTIC\EventDispatcher\Events\Traits;

/**
 * Trait StoppableEventTrait
 * @package ByTIC\EventDispatcher\Events\Traits
 */
trait StoppableEventTrait
{
    private $propagationStopped = false;

    /**
     * Returns whether further event listeners should be triggered.
     */
    public function isPropagationStopped(): bool
    {
        return $this->propagationStopped;
    }

    /**
     * Stops the propagation of the event to further event listeners.
     *
     * If multiple event listeners are connected to the same event, no
     * further event listener will be triggered once any trigger calls
     * stopPropagation().
     */
    public function stopPropagation(): void
    {
        $this->propagationStopped = true;
    }
}
