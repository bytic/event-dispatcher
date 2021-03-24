<?php

namespace ByTIC\EventDispatcher\Tests\ListenerProviders\Discover;

use ByTIC\EventDispatcher\ListenerProviders\Discover\DiscoverProvider;
use ByTIC\EventDispatcher\Tests\AbstractTest;
use ByTIC\EventDispatcher\Tests\Fixtures\Events\Event;
use Mockery\Mock;

/**
 * Class DiscoverProviderTest
 * @package ByTIC\EventDispatcher\Tests\ListenerProviders\Discover
 */
class DiscoverProviderTest extends AbstractTest
{
    public function test_discover()
    {
        $provider = new DiscoverProvider();
        $provider->addDiscoveryPath(TEST_FIXTURE_PATH . '/Listeners');

        $event = new Event();
        $listeners = $provider->getListenersForEvent($event);

        self::assertGreaterThanOrEqual(2, iterator_count($listeners));
    }

    public function test_discover_once()
    {
        /** @var Mock|DiscoverProvider $provider */
        $provider = \Mockery::mock(DiscoverProvider::class)->shouldAllowMockingProtectedMethods()->makePartial();
        $provider->shouldReceive('doDiscovery')->once();
        $provider->addDiscoveryPath(TEST_FIXTURE_PATH . '/Listeners');

        $event = new Event();
        $provider->getListenersForEvent($event);
        $provider->getListenersForEvent($event);
        $provider->getListenersForEvent($event);
    }
}
