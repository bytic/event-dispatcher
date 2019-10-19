<?php

namespace ByTIC\EventDispatcher\Tests\Dispatcher\Traits;

use ByTIC\EventDispatcher\Dispatcher\EventDispatcher;
use ByTIC\EventDispatcher\Tests\AbstractTest;
use ByTIC\EventDispatcher\Tests\Fixtures\Listeners\SimpleListener;

class HasListenersTraitTest extends AbstractTest
{
    /**
     * @var EventDispatcher
     */
    private $dispatcher;

    private $listener;

    private $listeners;

    public function testAddListener()
    {
        $this->dispatcher->addListener('TEST', $this->listener);
        self::assertCount(1, $this->dispatcher->getListeners('TEST'));
    }

    public function testHasListeners()
    {
        self::assertFalse($this->dispatcher->hasListeners('TEST'));
        $this->dispatcher->addListener('TEST', $this->listener);
        self::assertTrue($this->dispatcher->hasListeners('TEST'));
    }

    public function testRemoveAllListeners()
    {
        self::assertFalse($this->dispatcher->hasListeners('TEST'));

        $this->dispatcher->addListener('TEST', $this->listener);
        self::assertTrue($this->dispatcher->hasListeners('TEST'));

        $this->dispatcher->removeAllListeners('TEST');
        self::assertFalse($this->dispatcher->hasListeners('TEST'));
    }

    public function testRemoveListener()
    {
        self::assertFalse($this->dispatcher->hasListeners('TEST'));

        $this->dispatcher->addListener('TEST', $this->listener);
        $this->dispatcher->addListener('TEST', $this->listeners[1]);
        self::assertCount(2, $this->dispatcher->getListeners('TEST'));

        $this->dispatcher->removeListener('TEST', $this->listener);
        self::assertCount(1, $this->dispatcher->getListeners('TEST'));
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