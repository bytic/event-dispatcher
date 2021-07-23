<?php

namespace ByTIC\EventDispatcher\Dispatcher\Traits;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Trait SymfonyIntegration
 * @package ByTIC\EventDispatcher\Dispatcher\Traits
 */
trait SymfonyIntegration
{
    /**
     * {@inheritdoc}
     */
    public function dispatch(object $event, string $eventName = null): object
    {
        return parent::dispatch($event);
    }

    /**
     * @inheritDoc
     */
    public function addListener(string $eventName, $listener, int $priority = 0)
    {
        return $this->listenerProvider->addListener($eventName, $listener, $priority);
    }

    /**
     * {@inheritdoc}
     */
    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        foreach ($subscriber->getSubscribedEvents() as $eventName => $params) {
            if (\is_string($params)) {
                $this->addListener($eventName, [$subscriber, $params]);
            } elseif (\is_string($params[0])) {
                $this->addListener($eventName, [$subscriber, $params[0]], $params[1] ?? 0);
            } else {
                foreach ($params as $listener) {
                    $this->addListener($eventName, [$subscriber, $listener[0]], $listener[1] ?? 0);
                }
            }
        }
    }

    public function removeListener(string $eventName, $listener)
    {
        // TODO: Implement removeListener() method.
    }

    /**
     * {@inheritdoc}
     */
    public function removeSubscriber(EventSubscriberInterface $subscriber)
    {
        foreach ($subscriber->getSubscribedEvents() as $eventName => $params) {
            if (\is_array($params) && \is_array($params[0])) {
                foreach ($params as $listener) {
                    $this->removeListener($eventName, [$subscriber, $listener[0]]);
                }
            } else {
                $this->removeListener($eventName, [$subscriber, \is_string($params) ? $params : $params[0]]);
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function getListeners(string $eventName = null)
    {
        return $this->listenerProvider->getListenersForEvent($eventName);
    }

    public function getListenerPriority(string $eventName, $listener)
    {
        // TODO: Implement getListenerPriority() method.
    }

    public function hasListeners(string $eventName = null): bool
    {
        return count($this->listenerProvider->getListenersForEvent($eventName)) > 0;
    }
}