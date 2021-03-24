<?php

namespace ByTIC\EventDispatcher\Dispatcher;

use ByTIC\EventDispatcher\Dispatcher\Traits\HasListenersTrait;

/**
 * Class EventDispatcher
 * @package ByTIC\EventDispatcher\Dispatcher
 */
class EventDispatcher extends \League\Event\EventDispatcher implements EventDispatcherInterface
{
    use HasListenersTrait;
}

