<?php

namespace ByTIC\EventDispatcher\Events\Traits;

use ByTIC\EventDispatcher\Events\EventInterface;

/**
 * Trait HasNameTrait
 * @package ByTIC\EventDispatcher\Events\Traits
 */
trait HasNameTrait
{
    protected $name = null;

    public function eventName(): string
    {
        return $this->getName();
    }

    public function getName()
    {
        if ($this->name === null) {
            $this->name = __CLASS__;
        }
        return $this->name;
    }

    /**
     * @param null $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Create a new event instance.
     *
     * @param string $name
     * @param mixed ...$arguments
     * @return EventInterface|static
     */
    public static function named($name, ... $arguments)
    {
        $event = new static(... $arguments);/** @phpstan-ignore-line */
        $event->setName($name);
        return $event;
    }
}
