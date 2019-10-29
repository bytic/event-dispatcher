<?php

namespace ByTIC\EventDispatcher\Listeners;

use ByTIC\EventDispatcher\Events\EventInterface;

/**
 * Interface ListenerInterface
 * @package ByTIC\EventDispatcher\Listeners
 */
interface ListenerInterface
{

    /**
     * Handle an event.
     *
     * @param EventInterface $event
     *
     * @return void
     */
    public function handle(EventInterface $event);
}
