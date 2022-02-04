<?php

namespace ByTIC\EventDispatcher\Dispatcher;

/**
 * Class EventDispatcher
 * @package ByTIC\EventDispatcher\Dispatcher
 */
class EventDispatcher extends \Symfony\Component\EventDispatcher\EventDispatcher implements EventDispatcherInterface
{
    use Traits\ListenForInterfacesTrait;
    use Traits\MakeListenerTrait;
}
