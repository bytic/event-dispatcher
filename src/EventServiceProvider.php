<?php

namespace ByTIC\EventDispatcher;

use ByTIC\EventDispatcher\Discovery\RegisterDiscoveredEvents;
use ByTIC\EventDispatcher\Dispatcher\EventDispatcher;
use ByTIC\EventDispatcher\Dispatcher\EventDispatcherInterface;
use Nip\Container\ServiceProviders\Providers\AbstractSignatureServiceProvider;
use Nip\Container\ServiceProviders\Providers\BootableServiceProviderInterface;
use Psr\EventDispatcher\EventDispatcherInterface as PsrEventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as SymfonyEventDispatcherInterface;

/**
 * Class EventServiceProvider
 * @package ByTIC\EventDispatcher
 */
class EventServiceProvider extends AbstractSignatureServiceProvider implements BootableServiceProviderInterface
{
    public const DIPATCHER_NAME = 'events';

    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->registerDispatcher();
    }

    public function boot()
    {
        $basePath = $this->getContainer()->get('path');
        $basePath .= DIRECTORY_SEPARATOR . 'Listeners';
        if (false === is_dir($basePath)) {
            return;
        }
        $dispatcher = $this->getContainer()->get(static::DIPATCHER_NAME);

        $provider = new RegisterDiscoveredEvents($dispatcher);
        $provider->addDiscoveryPath($basePath);
        $provider->register();
    }

    protected function registerDispatcher()
    {
        $this->getContainer()->share('events', function () {
            return new EventDispatcher();
        });
    }


    /**
     * @inheritdoc
     */
    public function provides(): array
    {
        return [
            self::DIPATCHER_NAME,
            EventDispatcherInterface::class,
            PsrEventDispatcherInterface::class,
            SymfonyEventDispatcherInterface::class
        ];
    }
}
