<?php

namespace ByTIC\EventDispatcher\Tests\Fixtures\Listeners;

use ByTIC\EventDispatcher\Queue\Listeners\ShouldQueue;

/**
 * Class QueueListener
 * @package ByTIC\EventDispatcher\Tests\Fixtures\Listeners
 */
class QueueListener extends SimpleListener implements ShouldQueue
{
}
