<?php

namespace ByTIC\EventDispatcher\Tests;

use ByTIC\EventDispatcher\EventServiceProvider;
use Nip\Container\Container;

/**
 * Class EventServiceProviderTest
 * @package ByTIC\EventDispatcher\Tests
 */
class EventServiceProviderTest extends AbstractTest
{
    protected $provider;

    public function testRegister()
    {
        self::assertFalse($this->provider->getContainer()->has('events'));

        $this->provider->register();

        self::assertTrue($this->provider->getContainer()->has('events'));
    }

    protected function setUp(): void
    {
        parent::setUp();

        $container = new Container();
        Container::setInstance($container);

        $this->provider = new EventServiceProvider();
        $this->provider->setContainer($container);
    }
}
