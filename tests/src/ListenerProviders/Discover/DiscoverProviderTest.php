<?php

namespace ByTIC\EventDispatcher\Tests\ListenerProviders\Discover;

use ByTIC\EventDispatcher\ListenerProviders\Discover\DiscoverProvider;
use ByTIC\EventDispatcher\Tests\AbstractTest;
use ByTIC\EventDispatcher\Tests\Fixtures\Events\Event;

/**
 * Class DiscoverProviderTest
 * @package ByTIC\EventDispatcher\Tests\ListenerProviders\Discover
 */
class DiscoverProviderTest extends AbstractTest
{
    public function testDiscover()
    {
        $provider = new DiscoverProvider();
        $provider->addDiscoveryPath(TEST_FIXTURE_PATH . '/Listeners');

        $event = new Event();
        $listeners = $provider->getListenersForEvent($event);

        self::assertCount(1, $listeners);
    }
}