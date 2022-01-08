<?php

namespace ByTIC\EventDispatcher\Dispatcher\Traits;

/**
 * Trait ListenForInterfacesTrait
 * @package ByTIC\EventDispatcher\Dispatcher\Traits
 */
trait ListenForInterfacesTrait
{
    public function getListeners(string $eventName = null): array
    {
        $listeners = parent::getListeners($eventName);

        return class_exists($eventName, false)
            ? $this->addInterfaceListeners($eventName, $listeners)
            : $listeners;
    }

    /**
     * Add the listeners for the event's interfaces to the given array.
     *
     * @param string $eventName
     * @param array $listeners
     * @return array
     */
    protected function addInterfaceListeners($eventName, array $listeners = []): array
    {
        foreach (class_implements($eventName) as $interface) {
            $interfaceListeners = parent::getListeners($interface);
            if (count($interfaceListeners)) {
                $listeners = array_merge($listeners, $interfaceListeners);
            }
        }

        return $listeners;
    }
}
