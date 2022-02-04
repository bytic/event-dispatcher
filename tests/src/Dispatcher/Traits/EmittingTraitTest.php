<?php

namespace ByTIC\EventDispatcher\Tests\Dispatcher\Traits;

use ByTIC\EventDispatcher\Events\EventInterface;
use ByTIC\EventDispatcher\Tests\AbstractTest;
use ByTIC\EventDispatcher\Tests\Fixtures\Events\Event;
use ByTIC\EventDispatcher\Tests\Fixtures\Listeners\SimpleListener;

/**
 * Class EmittingTraitTest
 * @package ByTIC\EventDispatcher\Tests\Dispatcher\Traits
 */
class EmittingTraitTest extends AbstractTest
{
    public function testDispatch()
    {
        $dispatcher = $this->newMockDispatcher();
        $listener = new SimpleListener();

        $dispatcher->addListener('preFoo', $listener);
        $dispatcher->addListener('postFoo', $listener);

        $event = Event::named('preFoo');
        $dispatcher->dispatch($event, 'preFoo');

        static::assertTrue($listener->invoked('preFoo'));
        static::assertFalse($listener->invoked('postFoo'));

        static::assertInstanceOf(
            Event::class,
            $dispatcher->dispatch(Event::named('noevent'))
        );
        static::assertInstanceOf(
            EventInterface::class,
            $dispatcher->dispatch(new Event())
        );
    }

    public function testDispatchReturnsSameEvent()
    {
        $this->dispatcher = $this->newMockDispatcher();
        $event = new Event();
        $return = $this->dispatcher->dispatch($event);
        static::assertSame($event, $return);
    }

}
