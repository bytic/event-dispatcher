<?php

namespace ByTIC\EventDispatcher\Tests;

use ByTIC\EventDispatcher\EventServiceProvider;
use ByTIC\EventDispatcher\ListenerProviders\DefaultProvider;
use ByTIC\EventDispatcher\Tests\Fixtures\ListenerProviders\CustomProvider;
use Nip\Container\Container;
use Psr\EventDispatcher\ListenerProviderInterface;

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

    public function testRegisterListenerProviderGeneric()
    {
        $this->provider->register();

        self::assertTrue($this->provider->getContainer()->has('events.listeners'));
        self::assertTrue($this->provider->getContainer()->has(ListenerProviderInterface::class));

        $listenerProvider = $this->provider->getContainer()->get('events.listeners');
        self::assertInstanceOf(DefaultProvider::class, $listenerProvider);
    }

    public function testRegisterListenerProviderCustom()
    {
        $this->provider->register();
        $this->provider->getContainer()->add(ListenerProviderInterface::class, CustomProvider::class);

        self::assertTrue($this->provider->getContainer()->has('events.listeners'));
        self::assertTrue($this->provider->getContainer()->has(ListenerProviderInterface::class));

        $listenerProvider = $this->provider->getContainer()->get('events.listeners');
        self::assertInstanceOf(CustomProvider::class, $listenerProvider);
    }

    protected function setUp() : void
    {
        parent::setUp();

        $container = new Container();
        Container::setInstance($container);

        $this->provider = new EventServiceProvider();
        $this->provider->setContainer($container);
    }
}