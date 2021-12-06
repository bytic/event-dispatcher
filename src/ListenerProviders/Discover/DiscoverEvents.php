<?php

namespace ByTIC\EventDispatcher\ListenerProviders\Discover;

use Nip\Utility\Oop;
use Nip\Utility\Str;
use ReflectionClass;
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
     * @return array
     */
    protected static function getListenerClasses($paths): iterable
    {
        $paths = is_array($paths) ? $paths : [$paths];
        $files = (new Finder)->files()->in($paths);

        foreach ($files as $file) {
            yield from static::classFromFile($file);
        }

//        $astLocator = (new BetterReflection())->astLocator();
//        $directoriesSourceLocator = new DirectoriesSourceLocator($paths, $astLocator);
//        if (class_exists(\Roave\BetterReflection\Reflector\ClassReflector::class)) {
//            $reflector = new \Roave\BetterReflection\Reflector\ClassReflector($directoriesSourceLocator);
//            return $reflector->getAllClasses();
//        }
//
//        $reflector = new DefaultReflector($directoriesSourceLocator);
//        return $reflector->reflectAllClasses();
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
     * @param \Roave\BetterReflection\Reflection\ReflectionClass[] $listeners
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
                    $eventName = $method->getParameters()[0]->getClass()->getName();
                    $listenerEvents[$eventName][] = [$listener->getName(), $method->getName()];
                }
            } catch (\ReflectionException $e) {
            }
        }
        return array_filter($listenerEvents);
    }
}
