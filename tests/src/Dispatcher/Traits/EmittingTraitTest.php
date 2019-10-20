<?php

namespace ByTIC\EventDispatcher\Tests\Dispatcher\Traits;

use ByTIC\EventDispatcher\Dispatcher\EventDispatcher;
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
    /**
     * @var EventDispatcher
     */
    private $dispatcher;

    private $listener;

    private $listeners;

    public function testDispatch()
    {
        $this->dispatcher->addListener('preFoo', $this->listener);
        $this->dispatcher->addListener('postFoo', $this->listener);

        $this->dispatcher->dispatch(Event::named('preFoo'));

        $this->assertTrue($this->listener->preFooInvoked);
        $this->assertFalse($this->listener->postFooInvoked);

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
        $this->dispatcher = $this->createEventDispatcher();
        $this->listener = new SimpleListener();
        $this->listeners[] = $this->logicalAnd();
        $this->listeners[] = new SimpleListener();
    }

    protected function tearDown(): void
    {
        $this->dispatcher = null;
        $this->listener = null;
    }

    protected function createEventDispatcher()
    {
        return new EventDispatcher();
    }
}
