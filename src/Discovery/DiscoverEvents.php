<?php

namespace ByTIC\EventDispatcher\Discovery;

use Nip\Utility\Oop;
use Nip\Utility\Str;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class DiscoverEvents
 * @package ByTIC\EventDispatcher\ListenerProviders\Discover
 *
 * @internal
 */
class DiscoverEvents
{
    /**
     * Get all of the events and listeners by searching the given listener directory.
     *
     * @param array|string $listenerPaths
     * @return array
     */
    public static function within($listenerPaths): array
    {
        return static::getListenerEvents(
            static::getListenerClasses($listenerPaths)
        );
    }

    /**
     * @param array|string $paths
     * @return array
     */
    protected static function getListenerClasses($paths): iterable
    {
        $paths = is_array($paths) ? $paths : [$paths];
        $files = (new Finder)->files()->in($paths);

        foreach ($files as $file) {
            yield from static::classFromFile($file);
        }
    }

    /**
     * Extract the class name from the given file path.
     *
     * @param  \SplFileInfo  $file
     * @param  string  $basePath
     * @return array
     */
    protected static function classFromFile(SplFileInfo $file)
    {
        return Oop::classesInFile($file);
    }

    /**
     * @param array $listeners
     * @return array
     */
    protected static function getListenerEvents(iterable $listeners): array
    {
        $listenerEvents = [];
        foreach ($listeners as $listener) {
            try {
                $listener = new ReflectionClass($listener);
                foreach ($listener->getMethods() as $method) {
                    if (!$method->isPublic()) {
                        continue;
                    }
                    if (!Str::is('handle*', $method->name) ||
                        !isset($method->getParameters()[0])) {
                        continue;
                    }
                    $eventName = (string)$method->getParameters()[0]->getType();
                    $listenerEvents[$eventName][] = [$listener->getName(), $method->getName()];
                }
            } catch (ReflectionException $e) {
            }
        }
        return array_filter($listenerEvents);
    }
}