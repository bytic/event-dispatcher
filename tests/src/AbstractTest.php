<?php

namespace ByTIC\EventDispatcher\Tests;

use ByTIC\EventDispatcher\Dispatcher\EventDispatcher;
use Bytic\Phpqa\PHPUnit\TestCase;
use Mockery;
use Mockery\LegacyMockInterface;
use Mockery\Mock;
use Mockery\MockInterface;
use Nip\Container\Utility\Container;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class AbstractTest
 */
abstract class AbstractTest extends TestCase
{
    protected $object;

    /**
     * @return Mock|EventDispatcher
     */
    protected function mockDispatcherInContainer()
    {
        $dispatcher = $this->newMockDispatcher();
        Container::container()->set('events', $dispatcher);

        return $dispatcher;
    }

    /**
     * @return LegacyMockInterface|Mock|MockInterface|EventDispatcherInterface|EventDispatcher
     */
    protected function newMockDispatcher()
    {
        $dispatcher = Mockery::mock(EventDispatcher::class)
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();
        return $dispatcher;
    }
}
