<?php

namespace ByTIC\EventDispatcher\Tests\Fixtures\Listeners;

use ByTIC\EventDispatcher\Events\EventInterface;
use ByTIC\EventDispatcher\Listeners\ListenerInterface;

/**
 * Class SimpleListener
 * @package ByTIC\EventDispatcher\Tests\Fixtures\Listeners
 */
class SimpleListener implements ListenerInterface
{
    protected $events = [];

    /**
     * @param EventInterface $event
     */
    public function __invoke(EventInterface $event)
    {
        $this->handle($event);
    }

    /**
     * Handle an event.
     *
     * @param EventInterface $event
     *
     * @return void
     */
    public function handle(EventInterface $event)
    {
        $this->events[$event->getName()] = true;
    }

    /**
     * @param EventInterface|string $event
     * @return bool
     */
    public function invoked($event)
    {
        $name = is_object($event) ? $event->getName() : $event;
        return isset($this->events[$name]);
    }
}
