<?php

namespace ByTIC\EventDispatcher\Dispatcher;

use ByTIC\EventDispatcher\ListenerProviders\DefaultProvider;

/**
 * Class EventDispatcher
 * @package ByTIC\EventDispatcher\Dispatcher
 *
 * @property DefaultProvider $listenerProvider
 */
class EventDispatcher extends \League\Event\EventDispatcher implements EventDispatcherInterface
{
    use Traits\HasListenersTrait;
    use Traits\SymfonyIntegration;
}
