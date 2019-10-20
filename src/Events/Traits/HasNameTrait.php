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
     *
     * @return EventInterface|static
     */
    public static function named($name)
    {
        $event = new static();
        $event->setName($name);
        return $event;
    }
}