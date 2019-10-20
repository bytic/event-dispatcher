<?php

namespace ByTIC\EventDispatcher\Tests\Events\Traits;

use ByTIC\EventDispatcher\Tests\AbstractTest;
use ByTIC\EventDispatcher\Tests\Fixtures\Events\Event;

class HasNameTraitTest extends AbstractTest
{
    public function testGetNameEmpty()
    {
        $event = new Event();
        self::assertSame('ByTIC\EventDispatcher\Tests\Fixtures\Events\Event', $event->getName());
        self::assertSame(Event::class, $event->getName());
    }

    public function testNamed()
    {
        $event = Event::named('test');
        $this->assertSame('test', $event->getName());
    }
}
