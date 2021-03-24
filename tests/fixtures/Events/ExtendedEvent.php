<?php

namespace ByTIC\EventDispatcher\Tests\Fixtures\Events;

use ByTIC\EventDispatcher\Events\Dispatchable;
use ByTIC\EventDispatcher\Events\EventInterface;
use ByTIC\EventDispatcher\Events\EventTrait;
use Psr\EventDispatcher\StoppableEventInterface;

/**
 * Class ExtendedEvent
 * @package ByTIC\EventDispatcher\Tests\Fixtures\Events
 */
class ExtendedEvent extends Event
{
}
