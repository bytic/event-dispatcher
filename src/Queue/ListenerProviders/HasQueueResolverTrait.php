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
    protected $queueResolver;

    /**
     * Get the queue implementation from the resolver.
     *
     * @return \Illuminate\Contracts\Queue\Queue
     */
    protected function resolveQueue()
    {
        return call_user_func($this->queueResolver);
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