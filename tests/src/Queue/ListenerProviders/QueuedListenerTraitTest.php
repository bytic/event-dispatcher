<?php

namespace ByTIC\EventDispatcher\Tests\Queue\ListenerProviders;

use ByTIC\EventDispatcher\ListenerProviders\DefaultProvider;
use ByTIC\EventDispatcher\Tests\AbstractTest;
use ByTIC\EventDispatcher\Tests\Fixtures\Events\Event;
use ByTIC\EventDispatcher\Tests\Fixtures\Listeners\QueueListener;

/**
 * Class QueuedListenerTraitTest
 * @package ByTIC\EventDispatcher\Tests\Queue\ListenerProviders
 */
class QueuedListenerTraitTest extends AbstractTest
{

    public function testListenerWithInterfaceQueued()
    {
        $event = Event::named('preFoo');

        $listenerProvider = \Mockery::mock(DefaultProvider::class)->makePartial();
        $listenerProvider->shouldAllowMockingProtectedMethods();
        $listenerProvider->shouldReceive('queueHandler')->with(QueueListener::class, 'handle', $event);

        /** @var DefaultProvider $listenerProvider */
        $listener = $listenerProvider->makeListener(QueueListener::class);
        self::assertInstanceOf(\Closure::class, $listener);

        $listener($event);
    }
}