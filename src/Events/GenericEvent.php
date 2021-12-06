<?php

namespace ByTIC\EventDispatcher\Events;

/**
 * Trait EventTrait
 * @package ByTIC\EventDispatcher\Events
 */
class GenericEvent implements EventInterface, \ArrayAccess, \IteratorAggregate
{
    use EventTrait;
}
