<?php

namespace ByTIC\EventDispatcher\Dispatcher\Traits;

use ByTIC\EventDispatcher\ListenerProviders\ListenerProviderInterface;
use ByTIC\EventDispatcher\ListenerProviders\PriorityListenerProvider;
use ByTIC\EventDispatcher\Listeners\CallbackListener;
use ByTIC\EventDispatcher\Listeners\ListenerInterface;
use InvalidArgumentException;

/**
 * Trait HasListenersTrait
 * @package ByTIC\EventDispatcher\Dispatcher\Traits
 */
trait HasListenersTrait
{
    /**
     * @var ListenerProviderInterface
     */
    protected $listenerProvider = null;

    /**
     * @return ListenerProviderInterface
     */
    public function getListenerProvider(): ListenerProviderInterface
    {
        return $this->listenerProvider;
    }

    /**
     * @param ListenerProviderInterface $listenerProvider
     */
    public function setListenerProvider(ListenerProviderInterface $listenerProvider): void
    {
        $this->listenerProvider = $listenerProvider;
    }
}