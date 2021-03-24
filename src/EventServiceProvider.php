<?php

namespace ByTIC\EventDispatcher;

use ByTIC\EventDispatcher\Dispatcher\EventDispatcher;
use ByTIC\EventDispatcher\ListenerProviders\DefaultProvider;
use Nip\Container\ServiceProviders\Providers\AbstractSignatureServiceProvider;
use Psr\EventDispatcher\ListenerProviderInterface;

/**
 * Class EventServiceProvider
 * @package ByTIC\EventDispatcher
 */
class EventServiceProvider extends AbstractSignatureServiceProvider
{
    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->registerListenerProvider();
        $this->registerDispatcher();
    }

    protected function registerDispatcher()
    {
        $this->getContainer()->share('events', function () {
            return (new EventDispatcher($this->getContainer()->get('events.listeners')));
        });
    }

    protected function registerListenerProvider()
    {
        if (!$this->getContainer()->has(ListenerProviderInterface::class)) {
            $this->getContainer()->add(ListenerProviderInterface::class, DefaultProvider::class);
        }

        $this->getContainer()->share('events.listeners', function () {
            return $this->getContainer()->get(ListenerProviderInterface::class);
        });
    }

    /**
     * @inheritdoc
     */
    public function provides()
    {
        return ['events', 'events.listeners', ListenerProviderInterface::class];
    }
}
