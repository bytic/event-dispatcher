<?php

namespace ByTIC\EventDispatcher\ListenerProviders;

/**
 * Class DefaultProvider
 * @package ByTIC\EventDispatcher\ListenerProvider
 */
class DefaultProvider extends PriorityListenerProvider
{
    use Traits\ListenForInterfacesTrait;

    /**
     * @inheritDoc
     */
    public function getListenersForEvent(object $event): iterable
    {
        yield from parent::getListenersForEvent($event);

        if (method_exists($event, 'eventName')) {
            yield from $this->getListenersForEventName($event->eventName());
        } elseif (method_exists($event, 'getName')) {
            yield from $this->getListenersForEventName($event->getName());
        }
        yield from $this->getListenersForEventInterfaces($event);
    }

    /**
     * @param string $eventName
     * @param callable|string $listener
     * @param int $priority
     */
    public function addListener(string $eventName, $listener, int $priority = ListenerPriority::NORMAL): void
    {
        $this->attach($listener, $priority, $eventName);
    }

    /**
     * @param string $eventName
     * @param callable|string $listener
     * @param int $priority
     */
    public function listen(string $eventName, $listener, int $priority = ListenerPriority::NORMAL): void
    {
        $this->attach($listener, $priority, $eventName);
    }
}
