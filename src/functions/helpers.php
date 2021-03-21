<?php

use ByTIC\EventDispatcher\Events\EventInterface;

if (!function_exists('event')) {
    /**
     * Dispatch an event and call the listeners.
     *
     * @param object|EventInterface $event
     * @return object|EventInterface
     */
    function event(object $event)
    {
        return app('events')->dispatch($event);
    }
}
