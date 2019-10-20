<?php

namespace ByTIC\EventDispatcher\Events;

use ByTIC\EventDispatcher\Events\Traits\HasNameTrait;
use ByTIC\EventDispatcher\Events\Traits\StoppableEventTrait;

/**
 * Trait EventTrait
 * @package ByTIC\EventDispatcher\Events
 */
trait EventTrait
{
    use HasNameTrait;
    use StoppableEventTrait;
}