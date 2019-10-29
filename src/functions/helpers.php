<?php

use ByTIC\EventDispatcher\Events\EventInterface;

if (!function_exists('event')) {
    /**
     * Dispatch an event and call the listeners.
     *
     * @param  EventInterface $event
     * @return EventInterface
     */
    function event(EventInterface $event)
    {
        return app('events')->dispatch($event);
    }
}
