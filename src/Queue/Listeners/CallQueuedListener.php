<?php

namespace ByTIC\EventDispatcher\Queue\Listeners;

use ByTIC\EventDispatcher\Events\EventInterface;
use ByTIC\EventDispatcher\Listeners\ListenerInterface;
use ByTIC\Queue\JobQueue\Bus\PendingDispatch;
use ByTIC\Queue\JobQueue\Jobs\Job;
use ReflectionClass;

/**
 * Class CallQueuedListener
 * @package ByTIC\EventDispatcher\Queue\Listeners
 */
class CallQueuedListener implements ListenerInterface
{
    protected $listener;

    protected $listenerObject;

    /**
     * @inheritDoc
     */
    public function handle(EventInterface $event)
    {
        $this->queueEvent($event);
    }

    /**
     * @param mixed $listener
     */
    public function setListener($listener): void
    {
        $this->listener = $listener;
        $class = $listener[0];
        try {
            $this->listenerObject = (new ReflectionClass($class))->newInstanceWithoutConstructor();
        } catch (\ReflectionException $e) {
        }
    }

    /**
     * @param EventInterface $event
     */
    protected function queueEvent(EventInterface $event)
    {
        $job = new Job($this->listener);

        if (isset($this->listenerObject->connection)) {
            $job->onConnection($this->listenerObject->connection);
        }
        if (isset($this->listenerObject->queue)) {
            $job->onQueue($this->listenerObject->queue);
        }
        if (isset($this->listenerObject->delay)) {
            $job->delay($this->listenerObject->delay);
        }
        $job->arguments([$event]);

        (new PendingDispatch($job));
    }
}
