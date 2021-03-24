<?php

namespace ByTIC\EventDispatcher\Tests;

use ByTIC\EventDispatcher\Dispatcher\EventDispatcher;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Nip\Container\Utility\Container;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractTest
 */
abstract class AbstractTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    protected $object;

    /**
     * @return \Mockery\Mock|EventDispatcher
     */
    protected function mockDispatcherInContainer()
    {
        $dispatcher = \Mockery::mock(EventDispatcher::class)->shouldAllowMockingProtectedMethods()->makePartial();
        Container::container()->set('events', $dispatcher);

        return $dispatcher;
    }
}
