<?php

namespace ByTIC\EventDispatcher\ListenerProviders;

use ByTIC\EventDispatcher\ListenerProviders\Traits\ProviderUtilitiesTrait;
use ByTIC\EventDispatcher\Listeners\Collections\PriorityListenerCollection;

/**
 * Class PriorityListenerProvider
 * @package ByTIC\EventDispatcher\ListenerProviders
 */
class PriorityListenerProvider implements ListenerProviderInterface
{
    use ProviderUtilitiesTrait;

    /**
     * @var PriorityListenerCollection[]
     */
    protected $listeners;

    /**
     * @inheritDoc
     */
    public function getListenersForEvent(object $event): iterable
    {
        $eventType = static::getEventType($event);
        if (!isset($this->listeners[$eventType])) {
            return [];
        }
        yield from $this->listeners[$eventType];
    }

    /**
     * @param callable|string $listener
     * @param int $priority
     * @param string|null $type
     * @param string|null $id
     * @return string
     */
    public function attach($listener, int $priority = 0, string $type = null, string $id = null): string
    {
        $listener = self::makeListener($listener);
        $type = $type ?? $this->getParameterType($listener);
        $id = $id ?? $this->getListenerId($listener);
        $this->checkListenerCollection($type);


        return $this->listeners[$type]->addItem($listener, $priority, $id);
    }

    /**
     * @param string $type
     */
    protected function checkListenerCollection($type)
    {
        if (!isset($this->listeners[$type])) {
            $this->listeners[$type] = new PriorityListenerCollection();
        }
    }
}