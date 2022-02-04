<?php

namespace ByTIC\EventDispatcher\Tests\Discovery;

use ByTIC\EventDispatcher\Discovery\DiscoverEvents;
use ByTIC\EventDispatcher\Tests\AbstractTest;

/**
 * Class DiscoverEventsTest
 * @package ByTIC\EventDispatcher\Tests\Discovery
 */
class DiscoverEventsTest extends AbstractTest
{
    public function testWithin()
    {
        $events = DiscoverEvents::within(TEST_FIXTURE_PATH . '/Listeners');
        self::assertCount(1, $events);
    }
}
