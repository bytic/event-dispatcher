<?php

namespace ByTIC\EventDispatcher\Dispatcher\Traits;

use ByTIC\EventDispatcher\Events\EventFactory;
use ByTIC\EventDispatcher\Events\EventInterface;
use InvalidArgumentException;

/**
 * Trait HasEventsTrait
 * @package ByTIC\EventDispatcher\Dispatcher\Traits
 */
trait HasEventsTrait
{
    /**
     * Prepare an event for emitting.
     *
     * @param string|EventInterface $event
     *
     * @return EventInterface
     */
    protected function prepareEvent($event)
    {
        $event = $this->ensureEvent($event);

        return $event;
    }

    /**
     * Ensure event input is of type EventInterface or convert it.
     *
     * @param string|EventInterface $event
     *
     * @return EventInterface
     * @throws InvalidArgumentException
     *
     */
    protected function ensureEvent($event)
    {
        if (is_string($event)) {
            return EventFactory::named($event);
        }
        if (!$event instanceof EventInterface) {
            throw new InvalidArgumentException('Events should be provides as Event instances or string, received type: ' . gettype($event));
        }

        return $event;
    }
}
