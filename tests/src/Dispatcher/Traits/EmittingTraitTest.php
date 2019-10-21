<?php

namespace ByTIC\EventDispatcher\Tests\Dispatcher\Traits;

use ByTIC\EventDispatcher\Dispatcher\EventDispatcher;
use ByTIC\EventDispatcher\Events\EventInterface;
use ByTIC\EventDispatcher\ListenerProviders\DefaultProvider;
use ByTIC\EventDispatcher\ListenerProviders\ListenerProviderInterface;
use ByTIC\EventDispatcher\Tests\AbstractTest;
use ByTIC\EventDispatcher\Tests\Fixtures\Events\Event;
use ByTIC\EventDispatcher\Tests\Fixtures\Listeners\SimpleListener;

/**
 * Class EmittingTraitTest
 * @package ByTIC\EventDispatcher\Tests\Dispatcher\Traits
 */
class EmittingTraitTest extends AbstractTest
{
    /**
     * @var EventDispatcher
     */
    private $dispatcher;

    private $listenerProvider;

    private $listener;

    private $listeners;

    public function testDispatch()
    {
        $this->listenerProvider->listen('preFoo', $this->listener);
        $this->listenerProvider->listen('postFoo', $this->listener);

        $event = Event::named('preFoo');
        $this->dispatcher->dispatch($event);

        $this->assertTrue($this->listener->invoked('preFoo'));
        $this->assertFalse($this->listener->invoked('postFoo'));

        $this->assertInstanceOf(
            Event::class,
            $this->dispatcher->dispatch(Event::named('noevent'))
        );
        $this->assertInstanceOf(
            EventInterface::class,
            $this->dispatcher->dispatch(new Event())
        );
    }

    public function testDispatchReturnsSameEvent()
    {
        $event = new Event();
        $return = $this->dispatcher->dispatch($event);
        $this->assertSame($event, $return);
    }

    protected function setUp(): void
    {
        $this->listenerProvider = $this->createListenerProvider();
        $this->dispatcher = $this->createEventDispatcher($this->listenerProvider);
        $this->listener = new SimpleListener();
        $this->listeners[] = $this->logicalAnd();
        $this->listeners[] = new SimpleListener();
    }

    protected function tearDown(): void
    {
        $this->dispatcher = null;
        $this->listener = null;
    }

    /**
     * @return ListenerProviderInterface|DefaultProvider
     */
    protected function createListenerProvider()
    {
        return new DefaultProvider();
    }

    /**
     * @param $listenerProvider
     * @return EventDispatcher
     */
    protected function createEventDispatcher($listenerProvider)
    {
        return new EventDispatcher($listenerProvider);
    }
}
