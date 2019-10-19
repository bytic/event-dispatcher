<?php

namespace ByTIC\EventDispatcher\Dispatcher;

use ByTIC\EventDispatcher\Dispatcher\Traits\EmittingTrait;
use ByTIC\EventDispatcher\Dispatcher\Traits\HasEventsTrait;
use ByTIC\EventDispatcher\Dispatcher\Traits\HasListenersTrait;

class EventDispatcher implements EventDispatcherInterface
{
    use HasEventsTrait;
    use HasListenersTrait;
    use EmittingTrait;
}

