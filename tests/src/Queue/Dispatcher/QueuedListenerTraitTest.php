<?php

namespace ByTIC\EventDispatcher\Tests\Queue\Dispatcher;

use ByTIC\EventDispatcher\Tests\AbstractTest;
use ByTIC\EventDispatcher\Tests\Fixtures\Events\Event;
use ByTIC\EventDispatcher\Tests\Fixtures\Listeners\QueueListener;
use Closure;

/**
 * Class QueuedListenerTraitTest
 * @package ByTIC\EventDispatcher\Tests\Queue\ListenerProviders
 */
class QueuedListenerTraitTest extends AbstractTest
{
    public function testListenerWithInterfaceQueued()
    {
        $event = Event::named('preFoo');

        $dispatcher = $this->newMockDispatcher();
        $dispatcher->shouldReceive('queueHandler')->with(QueueListener::class, 'handle', $event);

        $listener = $dispatcher->makeListener(QueueListener::class);
        self::assertInstanceOf(Closure::class, $listener);

        $listener($event);
    }
}
