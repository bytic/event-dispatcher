<?php

namespace ByTIC\EventDispatcher\Tests\ListenerProviders\Discover;

use ByTIC\EventDispatcher\ListenerProviders\Discover\DiscoverEvents;
use ByTIC\EventDispatcher\Tests\AbstractTest;

/**
 * Class DiscoverEventsTest
 * @package ByTIC\EventDispatcher\Tests\ListenerProviders\Discover
 */
class DiscoverEventsTest extends AbstractTest
{
    public function testWithin()
    {
        $events = DiscoverEvents::within(TEST_FIXTURE_PATH . '/Listeners');
        self::assertCount(1, $events);
    }
}
