<?php

namespace ByTIC\EventDispatcher\Queue\ListenerProviders;

/**
 * Trait HasQueueResolverTrait
 * @package ByTIC\EventDispatcher\Queue\ListenerProviders
 */
trait HasQueueResolverTrait
{
    /**
     * The queue resolver instance.
     *
     * @var callable
     */
    protected $queueResolver = null;

    /**
     * Get the queue implementation from the resolver.
     *
     * @return \Illuminate\Contracts\Queue\Queue
     */
    protected function resolveQueue()
    {
        return call_user_func($this->getQueueResolver());
    }

    /**
     * @return callable
     */
    public function getQueueResolver()
    {
        if ($this->queueResolver === null) {
            $this->setQueueResolver(function () {
                return app('queue');
            });
        }
        return $this->queueResolver;
    }

    /**
     * Set the queue resolver implementation.
     *
     * @param callable $resolver
     * @return $this
     */
    public function setQueueResolver(callable $resolver)
    {
        $this->queueResolver = $resolver;
        return $this;
    }
}