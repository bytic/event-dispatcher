<?php

namespace ByTIC\EventDispatcher\Dispatcher\Traits;

use ByTIC\EventDispatcher\Listeners\CallbackListener;
use ByTIC\EventDispatcher\Listeners\ListenerInterface;
use InvalidArgumentException;

trait HasListenersTrait
{
    /**
     * The registered event listeners.
     *
     * @var array|ListenerInterface[]
     */
    protected $listeners = [];

    /**
     * The sorted listeners
     *
     * Listeners will get sorted and stored for re-use.
     *
     * @var array|ListenerInterface[]
     */
    protected $sortedListeners = [];

    /**
     * @param array $events
     * @param $listener
     * @param int $priority
     */
    public function listenFor($events, $listener, int $priority = 0)
    {
        foreach ((array)$events as $event) {
            $this->addListener($event, $listener, $priority);
        }
    }

    /**
     * @inheritdoc
     */
    public function addListener(string $event, $listener, int $priority = 0)
    {
        $listener = $this->ensureListener($listener);
        $this->listeners[$event][$priority][] = $listener;
        $this->clearSortedListeners($event);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getListeners($event)
    {
        if (array_key_exists($event, $this->sortedListeners)) {
            return $this->sortedListeners[$event];
        }
        return $this->sortedListeners[$event] = $this->getSortedListeners($event);
    }

    /**
     * @inheritdoc
     */
    public function hasListeners($event)
    {
        if (!isset($this->listeners[$event]) || count($this->listeners[$event]) === 0) {
            return false;
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function removeListener(string $eventName, $listener)
    {
        if (empty($this->listeners[$eventName])) {
            return;
        }

        if (\is_array($listener) && isset($listener[0]) && $listener[0] instanceof \Closure) {
            $listener[0] = $listener[0]();
        }
        foreach ($this->listeners[$eventName] as $priority => &$listeners) {
            foreach ($listeners as $k => &$v) {
                if ($v !== $listener && \is_array($v) && isset($v[0]) && $v[0] instanceof \Closure) {
                    $v[0] = $v[0]();
                }
                if ($v === $listener) {
                    $this->clearSortedListeners($eventName);
                    unset($listeners[$k]);
                }
            }
            if (!$listeners) {
                unset($this->listeners[$eventName][$priority]);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function removeAllListeners($event)
    {
        $this->clearSortedListeners($event);
        if ($this->hasListeners($event)) {
            unset($this->listeners[$event]);
        }
        return $this;
    }

    /**
     * Get the listeners sorted by priority for a given event.
     *
     * @param string $event
     *
     * @return ListenerInterface[]
     */
    protected function getSortedListeners($event)
    {
        if (!$this->hasListeners($event)) {
            return [];
        }
        $listeners = $this->listeners[$event];
        krsort($listeners);
        return call_user_func_array('array_merge', $listeners);
    }

    /**
     * Ensure the input is a listener.
     *
     * @param ListenerInterface|callable $listener
     *
     * @return ListenerInterface
     * @throws InvalidArgumentException
     *
     */
    protected function ensureListener($listener)
    {
        if ($listener instanceof ListenerInterface) {
            return $listener;
        }
        if (is_callable($listener)) {
            return CallbackListener::fromCallable($listener);
        }
        throw new InvalidArgumentException('Listeners should be ListenerInterface, Closure or callable. Received type: ' . gettype($listener));
    }

    /**
     * Clear the sorted listeners for an event
     *
     * @param $event
     */
    protected function clearSortedListeners($event)
    {
        unset($this->sortedListeners[$event]);
    }
}