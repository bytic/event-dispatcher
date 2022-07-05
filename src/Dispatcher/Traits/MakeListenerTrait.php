<?php

namespace ByTIC\EventDispatcher\Dispatcher\Traits;

use ByTIC\EventDispatcher\Queue\Dispatcher\QueuedListenerTrait;
use Closure;
use Nip\Utility\Str;

/**
 * Trait MakeListenerTrait
 * @package ByTIC\EventDispatcher\Dispatcher\Traits
 */
trait MakeListenerTrait
{
    use QueuedListenerTrait;

    /**
     * {@inheritdoc}
     */
    public function addListener(string $eventName, $listener, int $priority = 0)
    {
        $listener = $this->makeListener($listener);
        parent::addListener($eventName, $listener, $priority);
    }

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

        $listenerObject = is_object($class) ? $class : app($class);
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
