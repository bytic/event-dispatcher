<?php

namespace ByTIC\EventDispatcher\Dispatcher\Traits;

/**
 * Trait EmittingTrait
 * @package ByTIC\EventDispatcher\Dispatcher\Traits
 */
trait EmittingTrait
{
    /**
     * @inheritDoc
     */
    public function dispatch(object $event)
    {
        list($name, $event) = $this->prepareEvent($event);
        $this->invokeListeners($name, $event);
        return $event;
    }
}