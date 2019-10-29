<?php

namespace ByTIC\EventDispatcher\ListenerProviders\Discover;

use ByTIC\EventDispatcher\ListenerProviders\DefaultProvider;

/**
 * Class DiscoverProvider
 * @package ByTIC\EventDispatcher\ListenerProviders\Discover
 */
class DiscoverProvider extends DefaultProvider
{
    protected $discovered = null;

    protected $discoveryPath = null;

    /**
     * @inheritDoc
     */
    public function getListenersForEvent(object $event): iterable
    {
        $this->discover();
        return parent::getListenersForEvent($event);
    }

    protected function discover()
    {
        if ($this->discovered !== null) {
            return;
        }
        $eventsArray = DiscoverEvents::within($this->discoverEventsWithin());
        foreach ($eventsArray as $event => $listeners) {
            foreach ($listeners as $listener) {
                $this->listen($event, $listener);
            }
        }
    }

    /**
     * Get the listener directories that should be used to discover events.
     *
     * @return array
     */
    protected function discoverEventsWithin()
    {
        if ($this->discoveryPath === null) {
            $this->discoveryPath = $this->detectDiscoveryPath();
        }

        return $this->discoveryPath;
    }

    /**
     * @param string $path
     */
    public function addDiscoveryPath($path)
    {
        $this->discoveryPath[] = $path;
    }

    /**
     * @return array
     */
    protected function detectDiscoveryPath()
    {
        if (!defined('APPLICATION_PATH')) {
            return [];
        }
        $folder = APPLICATION_PATH . '/Listeners';
        if (!is_dir($folder)) {
            return [];
        }
        return [
            $folder,
        ];
    }
}
