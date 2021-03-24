<?php

namespace ByTIC\EventDispatcher\ListenerProviders\Discover;

use ByTIC\EventDispatcher\ListenerProviders\DefaultProvider;

/**
 * Class DiscoverProvider
 * @package ByTIC\EventDispatcher\ListenerProviders\Discover
 *
 * @internal
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
        $this->doDiscovery();
        $this->discovered = true;
    }

    protected function doDiscovery()
    {
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
    protected function discoverEventsWithin(): array
    {
        if ($this->discoveryPath === null) {
            $this->discoveryPath = $this->detectDiscoveryPath();
        }

        return $this->discoveryPath;
    }

    /**
     * @param string $path
     */
    public function addDiscoveryPath(string $path)
    {
        $this->discoveryPath[] = $path;
    }

    /**
     * @return array
     */
    protected function detectDiscoveryPath(): array
    {
        $paths = $this->detectDiscoveryFromConfig();
        if (count($paths)) {
            return $paths;
        }
        return $this->detectDiscoveryFromApplication();
    }

    protected function detectDiscoveryFromConfig(): array
    {
        if (!function_exists('config')) {
            return [];
        }

        $config = config('event-dispatcher.listener_paths');
        if (!$config) {
            return [];
        }
        $paths = $config->toArray();
        foreach ($paths as $key => $path) {
            if (!is_dir($path)) {
                unset($paths[$key]);
            }
        }
        return $paths;
    }

    protected function detectDiscoveryFromApplication(): array
    {
        $basePath = $this->detectApplicationPath();
        if (!is_dir($basePath)) {
            return [];
        }

        $folder = $basePath . '/Listeners';
        if (!is_dir($folder)) {
            return [];
        }

        return [
            $folder,
        ];
    }

    /**
     * @return false|string
     */
    protected function detectApplicationPath()
    {
        if (defined('APPLICATION_PATH')) {
            return APPLICATION_PATH;
        }
        if (!function_exists('app')) {
            return false;
        }
        $app = app();
        if ($app->has('path')) {
            return $app->get('path');
        }
        return false;
    }
}
