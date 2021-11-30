<?php

namespace ByTIC\EventDispatcher\ListenerProviders\Discover;

use Nip\Utility\Str;
use ReflectionClass;
use Roave\BetterReflection\BetterReflection;
use Roave\BetterReflection\Reflector\ClassReflector;
use Roave\BetterReflection\Reflector\DefaultReflector;
use Roave\BetterReflection\SourceLocator\Type\DirectoriesSourceLocator;

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
     * @param array $listenerPaths
     * @return array
     */
    public static function within($listenerPaths): array
    {
        return static::getListenerEvents(
            static::getListenerClasses($listenerPaths)
        );
    }

    /**
     * @param array $paths
     * @return array|\Roave\BetterReflection\Reflection\ReflectionClass[]
     */
    protected static function getListenerClasses($paths): array
    {
        $astLocator = (new BetterReflection())->astLocator();
        $paths = is_array($paths) ? $paths : [$paths];
        $directoriesSourceLocator = new DirectoriesSourceLocator($paths, $astLocator);
        if (class_exists(\Roave\BetterReflection\Reflector\ClassReflector::class)) {
            $reflector = new \Roave\BetterReflection\Reflector\ClassReflector($directoriesSourceLocator);
            return $reflector->getAllClasses();
        }

        $reflector = new DefaultReflector($directoriesSourceLocator);
        return $reflector->reflectAllClasses();
    }

    /**
     * @param \Roave\BetterReflection\Reflection\ReflectionClass[] $listeners
     * @return array
     */
    protected static function getListenerEvents(array $listeners): array
    {
        $listenerEvents = [];
        foreach ($listeners as $listener) {
            try {
                $listener = new ReflectionClass($listener->getName());
                foreach ($listener->getMethods() as $method) {
                    if (!$method->isPublic()) {
                        continue;
                    }
                    if (!Str::is('handle*', $method->name) ||
                        !isset($method->getParameters()[0])) {
                        continue;
                    }
                    $eventName = $method->getParameters()[0]->getClass()->getName();
                    $listenerEvents[$eventName][] = [$listener->getName(), $method->getName()];
                }
            } catch (\ReflectionException $e) {
            }
        }
        return array_filter($listenerEvents);
    }
}
