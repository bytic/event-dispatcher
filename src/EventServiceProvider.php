<?php

namespace ByTIC\EventDispatcher;

use ByTIC\EventDispatcher\Dispatcher\EventDispatcher;
use ByTIC\EventDispatcher\ListenerProviders\DefaultProvider;
use Nip\Container\ServiceProvider\AbstractSignatureServiceProvider;
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
        $this->getContainer()->singleton('events', function () {
            return (new EventDispatcher($this->getContainer()->get('events.listeners')));
        });
    }

    protected function registerListenerProvider()
    {
        $this->getContainer()->add(ListenerProviderInterface::class, DefaultProvider::class);

        $this->getContainer()->singleton('events.listeners', function () {
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