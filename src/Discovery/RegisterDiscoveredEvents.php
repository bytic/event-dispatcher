<?php

namespace ByTIC\EventDispatcher\Discovery;

use Nip\Cache\Cacheable\CanCache;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use function app;
use function config;

/**
 * Class DiscoverProvider
 * @package ByTIC\EventDispatcher\ListenerProviders\Discover
 *
 * @internal
 */
class RegisterDiscoveredEvents
{
    use CanCache;

    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @var ?array
     */
    protected $discovered = null;

    protected $discoveryPath = null;

    /**
     * RegisterDiscoveredEvents constructor.
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @inheritDoc
     */
    public function register()
    {
        $events = $this->discover();
        foreach ($events as $event => $listeners) {
            foreach ($listeners as $listener) {
                $this->dispatcher->addListener($event, $listener);
            }
        }
    }

    /**
     * @return null
     */
    protected function discover(): ?array
    {
        if ($this->discovered === null) {
            $data = $this->getDataFromCache();
            if (!is_array($data)) {
                $data = $this->doDiscovery();
                $this->saveDataToCache($data);
            }
            $this->discovered = $data;
        }
        return $this->discovered;
    }

    protected function doDiscovery(): array
    {
        $path = $this->discoverEventsWithin();
        $return = [];

        if (count($path) < 1) {
            return $return;
        }
        $eventsArray = DiscoverEvents::within($path);
        foreach ($eventsArray as $event => $listeners) {
            foreach ($listeners as $listener) {
                $return[$event][] = $listener;
            }
        }
        return $return;
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

    public function generateCacheData(): array
    {
        return $this->doDiscovery();
    }
}
