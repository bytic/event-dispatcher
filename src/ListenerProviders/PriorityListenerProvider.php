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
    use MakeListenerTrait;

    /**
     * @param callable|string $listener
     * @param int $priority
     * @param string|null $event
     * @param string|null $id
     * @return void
     */
    public function attach(
        $listener,
        int $priority = ListenerPriority::NORMAL,
        string $event = null,
        string $id = null
    ): void {
        $listener = self::makeListener($listener);
        $event = $event ?? $this->getParameterType($listener);
        $this->subscribeTo($event, $listener, $priority);
    }
}
