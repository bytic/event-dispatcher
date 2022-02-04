<?php

namespace ByTIC\EventDispatcher\ListenerProviders;

use Psr\EventDispatcher\ListenerProviderInterface;

/**
 * Class PriorityListenerProvider
 * @package ByTIC\EventDispatcher\ListenerProviders
 */
class PriorityListenerProvider implements ListenerProviderInterface
{
    use Traits\ProviderUtilitiesTrait;
    use Traits\MakeListenerTrait;

    protected $listenersPerEvent = [];

    protected function getListenersForEventName(string $eventName): iterable
    {
        if (!array_key_exists($eventName, $this->listenersPerEvent)) {
            return [];
        }

        return $this->listenersPerEvent[$eventName]->getListeners();
    }

    /**
     * @param callable|string $listener
     * @param int $priority
     * @param string|null $event
     * @return void
     */
    public function attach(
        $listener,
        int $priority = 0,
        string $event = null
    ): void {
        $listener = self::makeListener($listener);
        $event = $event ?? $this->getParameterType($listener);
        $this->subscribeTo($event, $listener, $priority);
    }


    public function subscribeTo(string $event, callable $listener, int $priority = 0): void
    {
        $group = array_key_exists($event, $this->listenersPerEvent)
            ? $this->listenersPerEvent[$event]
            : $this->listenersPerEvent[$event] = new PrioritizedListenersForEvent();

        $group->addListener($listener, $priority);
    }

    public function subscribeOnceTo(string $event, callable $listener, int $priority = ListenerPriority::NORMAL): void
    {
        $this->subscribeTo($event, new OneTimeListener($listener), $priority);
    }

    public function getListenersForEvent(object $event): iterable
    {
        /**
         * @var string $key
         * @var PrioritizedListenersForEvent $group
         */
        foreach ($this->listenersPerEvent as $key => $group) {
            if ($event instanceof $key) {
                yield from $group->getListeners();
            }
        }

        if (method_exists($event, 'eventName')) {
            yield from $this->getListenersForEventName($event->eventName());
        }
    }

//    public function subscribeListenersFrom(ListenerSubscriber $subscriber): void
//    {
//        $subscriber->subscribeListeners($this);
//    }
}
