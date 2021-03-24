<?php

namespace ByTIC\EventDispatcher\Tests\Events\Traits;

use ByTIC\EventDispatcher\Tests\AbstractTest;
use ByTIC\EventDispatcher\Tests\Fixtures\Events\Event;

/**
 * Class HasNameTraitTest
 * @package ByTIC\EventDispatcher\Tests\Events\Traits
 */
class HasNameTraitTest extends AbstractTest
{
    public function testGetNameEmpty()
    {
        $event = new Event();
        self::assertSame('ByTIC\EventDispatcher\Tests\Fixtures\Events\Event', $event->getName());
        self::assertSame(Event::class, $event->getName());
    }

    public function test_named()
    {
        $event = Event::named('test');
        $this->assertSame('test', $event->getName());
        $this->assertSame([], $event->arguments);
    }

    public function test_named_with_arguments()
    {
        $event = Event::named('test', 1, 2);
        $this->assertSame('test', $event->getName());
        $this->assertSame([1, 2], $event->arguments);
    }
}
