<?php

namespace ByTIC\EventDispatcher\ListenerProviders\Traits;

use ByTIC\EventDispatcher\Queue\ListenerProviders\QueuedListenerTrait;
use Closure;
use Nip\Utility\Str;

/**
 * Trait MakeListenerTrait
 * @package ByTIC\EventDispatcher\ListenerProviders\Traits
 */
trait MakeListenerTrait
{
    use QueuedListenerTrait;

    /**
     * Register an event listener with the dispatcher.
     *
     * @param Closure|string|array $listener
     * @return Closure
     */
    public function makeListener($listener): Closure
    {
        if (is_string($listener) || is_array($listener)) {
            return $this->createClassListener($listener);
        }
        if (is_object($listener)) {
            return $this->createObjectListener($listener);
        }

        return function ($event) use ($listener) {
            return $listener($event);
        };
    }

    /**
     * Create a class based listener using the IoC container.
     *
     * @param string $listener
     * @return Closure
     */
    protected function createClassListener($listener): Closure
    {
        return function ($event) use ($listener) {
            return call_user_func_array(
                $this->createClassCallable($listener),
                [$event]
            );
        };
    }

    /**
     * @param $listener
     * @return Closure
     */
    protected function createObjectListener($listener): Closure
    {
        return function ($event) use ($listener) {
            return $listener($event);
        };
    }

    /**
     * Create the class based event callable.
     *
     * @param string|array $listener
     * @return callable
     */
    protected function createClassCallable($listener)
    {
        [$class, $method] = $this->parseClassCallable($listener);

        if ($this->handlerShouldBeQueued($class)) {
            return $this->createQueuedHandlerCallable($class, $method);
        }

        $listenerObject = app($class);
        return [$listenerObject, $method];
    }

    /**
     * Parse the class listener into class and method.
     *
     * @param string|array $listener
     * @return array
     */
    protected function parseClassCallable($listener)
    {
        if (is_array($listener)) {
            return $listener;
        }
        return Str::parseCallback($listener, 'handle');
    }
}
