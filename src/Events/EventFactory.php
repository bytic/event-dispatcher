<?php

namespace ByTIC\EventDispatcher\Events;

/**
 * Class EventFactory
 * @package ByTIC\EventDispatcher\Events
 */
class EventFactory
{
    /**
     * Create a new event instance.
     *
     * @param string $name
     *
     * @return EventInterface
     */
    public static function named($name)
    {
        return new static($name);
    }
}