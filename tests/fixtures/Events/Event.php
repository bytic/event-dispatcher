<?php

namespace ByTIC\EventDispatcher\Tests\Fixtures\Events;

use ByTIC\EventDispatcher\Events\EventInterface;
use ByTIC\EventDispatcher\Events\EventTrait;
use Psr\EventDispatcher\StoppableEventInterface;

class Event implements EventInterface, StoppableEventInterface
{
    use EventTrait;
}
