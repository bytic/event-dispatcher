<?php

namespace ByTIC\EventDispatcher\Dispatcher;

use ByTIC\EventDispatcher\ListenerProviders\DefaultProvider;

/**
 * Class EventDispatcher
 * @package ByTIC\EventDispatcher\Dispatcher
 *
 * @property DefaultProvider $listenerProvider
 */
class EventDispatcher extends \Symfony\Component\EventDispatcher\EventDispatcher implements EventDispatcherInterface
{
}
