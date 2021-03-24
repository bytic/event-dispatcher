<?php

namespace ByTIC\EventDispatcher\ListenerProviders\Traits;

/**
 * Trait ListenForInterfacesTrait
 * @package ByTIC\EventDispatcher\ListenerProviders\Traits
 */
trait ListenForInterfacesTrait
{
    /**
     * @param object $event
     * @return iterable
     */
    public function getListenersForEventInterfaces(object $event): iterable
    {
        foreach (class_implements($event) as $interface) {
            if (isset($this->listeners[$interface])) {
                yield from $this->listeners[$interface];
            }
        }
    }
}
