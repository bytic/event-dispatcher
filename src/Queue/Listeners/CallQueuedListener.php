<?php

namespace ByTIC\EventDispatcher\Queue\Listeners;

use ByTIC\EventDispatcher\Events\EventInterface;
use ByTIC\EventDispatcher\Listeners\ListenerInterface;
use ReflectionClass;

/**
 * Class CallQueuedListener
 * @package ByTIC\EventDispatcher\Queue\Listeners
 */
class CallQueuedListener implements ListenerInterface
{
    protected $listener;

    protected $listenerObject;

    protected $queueHandler;

    /**
     * @param mixed $queueHandler
     */
    public function setQueueHandler($queueHandler): void
    {
        $this->queueHandler = $queueHandler;
    }

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
        $connection = $this->createConnection();
        $data = $this->queueData($event);
        $queue = $this->listenerObject->queue ?? null;

        isset($this->listenerObject->delay)
            ? $connection->laterOn($queue, $this->listenerObject->delay, $data)
            : $connection->pushOn($queue, $data);
    }

    /**
     * @param EventInterface $event
     * @return array
     */
    protected function queueData(EventInterface $event)
    {
        return [
            'listener' => $this->listener,
            'event' => $event,
        ];
    }

    /**
     * @return mixed
     */
    protected function createConnection()
    {
        return $this->queueHandler->connection(
            $this->listenerObject->connection ?? null
        );
    }
}
