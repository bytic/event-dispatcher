<?php

namespace ByTIC\EventDispatcher\ListenerProviders;

use ByTIC\EventDispatcher\ListenerProviders\Traits\MakeListenerTrait;
use ByTIC\EventDispatcher\ListenerProviders\Traits\ProviderUtilitiesTrait;
use League\Event\ListenerPriority;
use League\Event\PrioritizedListenerRegistry;
use Psr\EventDispatcher\ListenerProviderInterface;

/**
 * Class PriorityListenerProvider
 * @package ByTIC\EventDispatcher\ListenerProviders
 */
class PriorityListenerProvider extends PrioritizedListenerRegistry implements ListenerProviderInterface
{
    use ProviderUtilitiesTrait;

    protected function getListenersForEventName(string $eventName): iterable
    {
        if ( ! array_key_exists($eventName, $this->listenersPerEvent)) {
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
        int $priority = ListenerPriority::NORMAL,
        string $event = null
    ): void {
        $listener = self::makeListener($listener);
        $event = $event ?? $this->getParameterType($listener);
        $this->subscribeTo($event, $listener, $priority);
    }
}
