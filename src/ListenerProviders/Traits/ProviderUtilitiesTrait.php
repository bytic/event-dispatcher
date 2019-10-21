<?php

namespace ByTIC\EventDispatcher\ListenerProviders\Traits;

use Fig\EventDispatcher\ParameterDeriverTrait;
use Nip\Utility\Str;

/**
 * Trait ProviderUtilitiesTrait
 * @package ByTIC\EventDispatcher\ListenerProvider
 */
trait ProviderUtilitiesTrait
{
    use ParameterDeriverTrait;

    /**
     * Derives a predictable ID from the listener if possible.
     *
     * @param callable $listener
     *   The listener for which to derive an ID.
     * @return string|null
     *   The derived ID if possible or null if no reasonable ID could be derived.
     * @todo If we add support for annotations or similar for identifying listeners that logic would go here.
     *
     * It's OK for this method to return null, as OrderedCollection will generate a random
     * ID if necessary.  It will also handle duplicates for us.  This method is just a
     * suggestion.
     *
     */
    protected function getListenerId(callable $listener): ?string
    {
        if ($this->isFunctionCallable($listener)) {
            // Function callables are strings, so use that directly.
            return (string)$listener;
        }
        if ($this->isClassCallable($listener)) {
            return $listener[0] . '::' . $listener[1];
        }
        if ($this->isObjectCallable($listener)) {
            return get_class($listener[0]) . '::' . $listener[1];
        }
        // Anything else we can't derive an ID for logically.
        return null;
    }

    /**
     * @param $event
     * @return string
     */
    public static function getEventType($event)
    {
        if (is_object($event)) {
            if (method_exists($event, 'getName')) {
                return $event->getName();
            }
            return get_class($event);
        }
        return $event;
    }

    /**
     * Register an event listener with the dispatcher.
     *
     * @param \Closure|string $listener
     * @return \Closure
     */
    public function makeListener($listener)
    {
        if (is_string($listener)) {
            return $this->createClassListener($listener);
        }
        if (is_object($listener)) {
            return $this->createObjectListener($listener);
        }
    }

    /**
     * Create a class based listener using the IoC container.
     *
     * @param string $listener
     * @return \Closure
     */
    protected function createClassListener($listener)
    {
        return function ($event) use ($listener) {
            return call_user_func_array(
                $this->createClassCallable($listener), $event
            );
        };
    }

    /**
     * @param $listener
     * @return \Closure
     */
    protected function createObjectListener($listener)
    {
        return function ($event) use ($listener) {
            return $listener($event);
        };
    }

    /**
     * Create the class based event callable.
     *
     * @param string $listener
     * @return callable
     */
    protected function createClassCallable($listener)
    {
        [$class, $method] = $this->parseClassCallable($listener);
        return [$class, $method];
    }

    /**
     * Parse the class listener into class and method.
     *
     * @param string $listener
     * @return array
     */
    protected function parseClassCallable($listener)
    {
        return Str::parseCallback($listener, 'handle');
    }
}
