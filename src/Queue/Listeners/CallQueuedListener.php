<?php

namespace ByTIC\EventDispatcher\Queue\Listeners;

use ByTIC\EventDispatcher\Events\EventInterface;
use ByTIC\EventDispatcher\Listeners\ListenerInterface;
use ByTIC\Queue\Connections\Connection;
use ByTIC\Queue\Messages\Message;
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
     * @throws \Interop\Queue\Exception
     * @throws \Interop\Queue\Exception\InvalidDestinationException
     * @throws \Interop\Queue\Exception\InvalidMessageException
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
     * @throws \Interop\Queue\Exception
     * @throws \Interop\Queue\Exception\InvalidDestinationException
     * @throws \Interop\Queue\Exception\InvalidMessageException
     */
    protected function queueEvent(EventInterface $event)
    {
        /** @var Connection $connection */
        $connection = $this->createConnection();
        $message = $this->queueMessage($event);
        $queue = $this->listenerObject->queue ?? null;

        isset($this->listenerObject->delay)
            ? $connection->laterOn($message, $queue, $this->listenerObject->delay)
            : $connection->sendOn($message, $queue);
    }

    /**
     * @param EventInterface $event
     * @return Message
     */
    protected function queueMessage(EventInterface $event)
    {
        return new Message($this->queueData($event));
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
