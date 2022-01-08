<?php

namespace ByTIC\EventDispatcher;

use ByTIC\EventDispatcher\Dispatcher\EventDispatcher;
use Nip\Container\ServiceProviders\Providers\AbstractSignatureServiceProvider;
use Nip\Container\ServiceProviders\Providers\BootableServiceProviderInterface;

/**
 * Class EventServiceProvider
 * @package ByTIC\EventDispatcher
 */
class EventServiceProvider extends AbstractSignatureServiceProvider implements BootableServiceProviderInterface
{
    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->registerDispatcher();
    }

    public function boot()
    {

        // TODO: Implement boot() method.
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
        return ['events'];
    }
}
