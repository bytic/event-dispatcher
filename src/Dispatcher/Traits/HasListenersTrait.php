<?php

namespace ByTIC\EventDispatcher\Dispatcher\Traits;

use \Psr\EventDispatcher\ListenerProviderInterface;

/**
 * Trait HasListenersTrait
 * @package ByTIC\EventDispatcher\Dispatcher\Traits
 */
trait HasListenersTrait
{

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