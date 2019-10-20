<?php

namespace ByTIC\EventDispatcher\Dispatcher\Traits;

use ByTIC\EventDispatcher\Events\EventTrait;

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

    protected function invokeListeners($name, $event)
    {
        $listeners = $this->getListeners($name);
        $this->callListeners($listeners, $event);
    }

    /**
     * @param iterable $listeners
     * @param object|EventTrait $event
     */
    protected function callListeners(iterable $listeners, object $event)
    {
        foreach ($listeners as $listener) {
            if (method_exists($event, 'isPropagationStopped') && $event->isPropagationStopped()) {
                break;
            }
            $arguments = [$event];
            call_user_func_array([$listener, 'handle'], $arguments);
        }
    }
}
