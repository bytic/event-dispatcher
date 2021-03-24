<?php

namespace ByTIC\EventDispatcher\Tests\Events;

use ByTIC\EventDispatcher\Tests\AbstractTest;
use ByTIC\EventDispatcher\Tests\Fixtures\Events\Event;
use ByTIC\EventDispatcher\Tests\Fixtures\Events\ExtendedEvent;

/**
 * Class DispatchableTest
 * @package ByTIC\EventDispatcher\Tests\Events
 */
class DispatchableTest extends AbstractTest
{
    public function test_dispatch()
    {
        $dispatcher = $this->mockDispatcherInContainer();
        $dispatcher->shouldReceive('dispatch')->twice()->andReturnArg(0);

        $event = Event::dispatch();
        self::assertInstanceOf(Event::class, $event);

        $event = ExtendedEvent::dispatch();
        self::assertInstanceOf(ExtendedEvent::class, $event);
    }

    public function test_dispatchIf()
    {
        $dispatcher = $this->mockDispatcherInContainer();
        $dispatcher->shouldReceive('dispatch')->once()->andReturnArg(0);

        self::assertSame(null ,Event::dispatchIf(false));

        $event = Event::dispatchIf(true);
        self::assertInstanceOf(Event::class, $event);
    }

    public function test_dispatchUnless()
    {
        $dispatcher = $this->mockDispatcherInContainer();
        $dispatcher->shouldReceive('dispatch')->once()->andReturnArg(0);


        self::assertSame(null ,Event::dispatchUnless(true));

        $event = Event::dispatchUnless(false);
        self::assertInstanceOf(Event::class, $event);
    }
}