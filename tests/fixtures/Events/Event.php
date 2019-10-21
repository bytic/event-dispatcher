<?php

namespace ByTIC\EventDispatcher\Tests\Fixtures\Events;

use ByTIC\EventDispatcher\Events\EventInterface;
use ByTIC\EventDispatcher\Events\EventTrait;
use Psr\EventDispatcher\StoppableEventInterface;

/**
 * Class Event
 * @package ByTIC\EventDispatcher\Tests\Fixtures\Events
 */
class Event implements EventInterface, StoppableEventInterface
{
    use EventTrait;

    protected $data = '';

    /**
     * @param $data
     */
    public function addData($data)
    {
        $this->data .= $data;
    }

    /**
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }
}
