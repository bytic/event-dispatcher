<?php

namespace ByTIC\EventDispatcher\Events;

/**
 * Interface EventInterface
 * @package ByTIC\EventDispatcher\Events
 */
interface EventInterface
{
    /**
     * Get the event name.
     *
     * @return string
     */
    public function getName();
}
