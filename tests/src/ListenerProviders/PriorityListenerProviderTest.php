<?php

namespace ByTIC\EventDispatcher\Tests\ListenerProviders;

use ByTIC\EventDispatcher\ListenerProviders\PriorityListenerProvider;
use ByTIC\EventDispatcher\Tests\AbstractTest;
use ByTIC\EventDispatcher\Tests\Fixtures\Events\Event;
use ByTIC\EventDispatcher\Tests\Fixtures\Listeners\SimpleListener;

/**
 * Class PriorityListenerProviderTest
 * @package ByTIC\EventDispatcher\Tests\ListenerProviders
 */
class PriorityListenerProviderTest extends AbstractTest
{
    public function testGetListenersForEvent()
    {
        $provider = new PriorityListenerProvider();

        $provider->attach([SimpleListener::class, 'handle'], 1, Event::class);
        $provider->attach(SimpleListener::class, 1, 'null');
        $provider->attach(SimpleListener::class, 3, Event::class);
        $provider->attach(SimpleListener::class, 2, Event::class);

        $event = new Event();
        $listeners = $provider->getListenersForEvent($event);

        self::assertCount(3, $listeners);
    }
}
