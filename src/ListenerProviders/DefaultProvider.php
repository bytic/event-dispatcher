<?php

namespace ByTIC\EventDispatcher\ListenerProviders;

use ByTIC\EventDispatcher\ListenerProviders\Traits\ListenForInterfacesTrait;
use ByTIC\EventDispatcher\ListenerProviders\Traits\MakeListenerTrait;
use ByTIC\EventDispatcher\ListenerProviders\Traits\ProviderUtilitiesTrait;
use Psr\EventDispatcher\ListenerProviderInterface;

/**
 * Class DefaultProvider
 * @package ByTIC\EventDispatcher\ListenerProvider
 */
class DefaultProvider implements ListenerProviderInterface
{
    use ProviderUtilitiesTrait;
    use MakeListenerTrait;
    use ListenForInterfacesTrait;

    protected $listeners = [];

    /**
     * @inheritDoc
     */
    public function getListenersForEvent(object $event): iterable
    {
        $eventType = static::getEventType($event);
        if (isset($this->listeners[$eventType])) {
            yield from $this->listeners[$eventType];
        }
        yield from $this->getListenersForEventInterfaces($event);
    }

    /**
     * @param string $eventType
     * @param callable|string $listener
     */
    public function listen(string $eventType, $listener): void
    {
        if (!isset($this->listeners[$eventType])) {
            $this->listeners[$eventType] = [];
        }

        $listener = self::makeListener($listener);

        if (\in_array($listener, $this->listeners[$eventType], true)) {
            return;
        }
        $this->listeners[$eventType][] = $listener;
    }
}