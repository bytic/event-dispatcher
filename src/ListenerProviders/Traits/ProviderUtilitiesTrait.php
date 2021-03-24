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
}
