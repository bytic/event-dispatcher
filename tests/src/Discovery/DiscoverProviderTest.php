<?php

namespace ByTIC\EventDispatcher\Tests\Discovery;

use ByTIC\EventDispatcher\Discovery\RegisterDiscoveredEvents;
use ByTIC\EventDispatcher\Tests\AbstractTest;
use ByTIC\EventDispatcher\Tests\Fixtures\Events\Event;
use Mockery;
use Mockery\Mock;

/**
 * Class DiscoverProviderTest
 * @package ByTIC\EventDispatcher\Tests\Discovery
 */
class DiscoverProviderTest extends AbstractTest
{
    public function test_discover()
    {
        $dispatcher = $this->newMockDispatcher();

        $provider = new RegisterDiscoveredEvents($dispatcher);
        $provider->addDiscoveryPath(TEST_FIXTURE_PATH . '/Listeners');
        $provider->register();

        $listeners = $dispatcher->getListeners(get_class(new Event()));

        self::assertGreaterThanOrEqual(2, count($listeners));
    }

    public function test_discover_once()
    {
        /** @var Mock|RegisterDiscoveredEvents $provider */
        $provider = Mockery::mock(RegisterDiscoveredEvents::class)->shouldAllowMockingProtectedMethods()->makePartial();
        $provider->shouldReceive('doDiscovery')->once();
        $provider->addDiscoveryPath(TEST_FIXTURE_PATH . '/Listeners');

        $provider->register();
        $provider->register();
        $provider->register();
    }
}
