<?php

namespace ByTIC\EventDispatcher\Events\Traits;

/**
 * Trait HasNameTrait
 * @package ByTIC\EventDispatcher\Events\Traits
 */
trait HasArgumentsTrait
{
    protected $arguments;

    /**
     * Get argument by key.
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException if key is not found
     */
    public function getArgument(string $key)
    {
        if ($this->hasArgument($key)) {
            return $this->arguments[$key];
        }

        throw new \InvalidArgumentException(sprintf('Argument "%s" not found.', $key));
    }

    /**
     * Add argument to event.
     *
     * @param mixed $value Value
     *
     * @return $this
     */
    public function setArgument(string $key, $value)
    {
        $this->arguments[$key] = $value;

        return $this;
    }

    /**
     * Getter for all arguments.
     *
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * Set args property.
     *
     * @return $this
     */
    public function setArguments(array $args = [])
    {
        $this->arguments = $args;

        return $this;
    }

    /**
     * Has argument.
     *
     * @return bool
     */
    public function hasArgument(string $key)
    {
        return \array_key_exists($key, $this->arguments);
    }

    /**
     * ArrayAccess for argument getter.
     *
     * @param string $key Array key
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException if key does not exist in $this->args
     */
    public function offsetGet($key)
    {
        return $this->getArgument($key);
    }

    /**
     * ArrayAccess for argument setter.
     *
     * @param string $key Array key to set
     * @param mixed $value Value
     *
     * @return void
     */
    public function offsetSet($key, $value)
    {
        $this->setArgument($key, $value);
    }

    /**
     * ArrayAccess for unset argument.
     *
     * @param string $key Array key
     *
     * @return void
     */
    public function offsetUnset($key)
    {
        if ($this->hasArgument($key)) {
            unset($this->arguments[$key]);
        }
    }

    /**
     * ArrayAccess has argument.
     *
     * @param string $key Array key
     *
     * @return bool
     */
    public function offsetExists($key)
    {
        return $this->hasArgument($key);
    }

    /**
     * IteratorAggregate for iterating over the object like an array.
     *
     * @return \ArrayIterator<string, mixed>
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->arguments);
    }
}
