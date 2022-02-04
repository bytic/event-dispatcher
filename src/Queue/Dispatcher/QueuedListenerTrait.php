<?php

namespace ByTIC\EventDispatcher\Queue\Dispatcher;

use ByTIC\EventDispatcher\Queue\Listeners\CallQueuedListener;
use ByTIC\EventDispatcher\Queue\Listeners\ShouldQueue;
use Closure;
use Exception;
use ReflectionClass;

/**
 * Trait QueuedListenerTrait
 * @package ByTIC\EventDispatcher\ListenerProviders\Traits
 */
trait QueuedListenerTrait
{
    /**
     * Determine if the event handler class should be queued.
     *
     * @param string $class
     * @return bool
     */
    protected function handlerShouldBeQueued($class): bool
    {
        try {
            return (new ReflectionClass($class))->implementsInterface(
                ShouldQueue::class
            );
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Create a callable for putting an event handler on the queue.
     *
     * @param string $class Listener class
     * @param string $method
     * @return Closure
     */
    protected function createQueuedHandlerCallable(string $class, string $method): Closure
    {
        return function ($event) use ($class, $method) {
//            $arguments = array_map(function ($a) {
//                return is_object($a) ? clone $a : $a;
//            }, func_get_args());

            if ($this->handlerWantsToBeQueued($class, $event)) {
                $this->queueHandler($class, $method, $event);
            }
        };
    }

    /**
     * Determine if the event handler wants to be queued.
     *
     * @param string $class
     * @param mixed $event
     * @return bool
     */
    protected function handlerWantsToBeQueued(string $class, $event): bool
    {
        if (method_exists($class, 'shouldQueue')) {
            $listener = new $class();
            /** @noinspection PhpUndefinedMethodInspection */
            return $listener->shouldQueue($event);
        }
        return true;
    }

    /**
     * Queue the handler class.
     *
     * @param string $class
     * @param string $method
     * @param mixed $event
     * @return void
     */
    protected function queueHandler($class, $method, $event)
    {
        $listener = new CallQueuedListener();
        $listener->setListener([$class, $method]);
        $listener->handle($event);
    }
}
