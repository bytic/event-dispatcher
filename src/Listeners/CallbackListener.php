<?php

namespace ByTIC\EventDispatcher\Listeners;

use ByTIC\EventDispatcher\Events\EventInterface;

/**
 * Class CallbackListener
 * @package ByTIC\EventDispatcher\Listeners
 */
class CallbackListener implements ListenerInterface
{
    /**
     * The callback.
     *
     * @var callable
     */
    protected $callback;

    /**
     * Create a new callback listener instance.
     *
     * @param callable $callback
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * @inheritdoc
     */
    public function handle(EventInterface $event)
    {
        call_user_func_array($this->callback, func_get_args());
    }

    /**
     * Named constructor
     *
     * @param callable $callable
     *
     * @return static
     */
    public static function fromCallable(callable $callable)
    {
        return new static($callable);
    }
}
