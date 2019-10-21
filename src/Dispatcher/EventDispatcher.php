<?php

namespace ByTIC\EventDispatcher\Dispatcher;

use ByTIC\EventDispatcher\Dispatcher\Traits\EmittingTrait;
use ByTIC\EventDispatcher\Dispatcher\Traits\HasEventsTrait;
use ByTIC\EventDispatcher\Dispatcher\Traits\HasListenersTrait;
use ByTIC\EventDispatcher\ListenerProviders\ListenerProviderInterface;

/**
 * Class EventDispatcher
 * @package ByTIC\EventDispatcher\Dispatcher
 */
class EventDispatcher implements EventDispatcherInterface
{
    use HasEventsTrait;
    use HasListenersTrait;
    use EmittingTrait;

    /**
     * EventDispatcher constructor.
     * @param ListenerProviderInterface $listenerProvider
     */
    public function __construct(ListenerProviderInterface $listenerProvider)
    {
        $this->listenerProvider = $listenerProvider;
    }
}

