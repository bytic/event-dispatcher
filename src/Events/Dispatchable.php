<?php

namespace ByTIC\EventDispatcher\Events;

/**
 * Class Dispatchable
 * @package ByTIC\EventDispatcher\Events
 */
trait Dispatchable
{
    /**
     * Dispatch the event with the given arguments.
     *
     * @return EventInterface|object
     */
    public static function dispatch()
    {
        return event(new static(...func_get_args())); /** @phpstan-ignore-line */
    }

    /**
     * Dispatch the event with the given arguments if the given truth test passes.
     *
     * @param  bool  $boolean
     * @return EventInterface|object|void
     */
    public static function dispatchIf($boolean, ...$arguments)
    {
        if ($boolean) {
            return static::dispatch(...$arguments);
        }
    }

    /**
     * Dispatch the event with the given arguments unless the given truth test passes.
     *
     * @param  bool  $boolean
     * @return EventInterface|object|void
     */
    public static function dispatchUnless($boolean, ...$arguments)
    {
        if (! $boolean) {
            return static::dispatch(...$arguments);
        }
    }
}
