<?php

namespace ByTIC\EventDispatcher\Tests\Fixtures\Listeners;

use ByTIC\EventDispatcher\Events\EventInterface;
use ByTIC\EventDispatcher\Listeners\ListenerInterface;

class SimpleListener implements ListenerInterface
{

    /**
     * Handle an event.
     *
     * @param EventInterface $event
     *
     * @return void
     */
    public function handle(EventInterface $event)
    {
        // TODO: Implement handle() method.
    }
}

