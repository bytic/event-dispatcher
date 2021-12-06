<?php

namespace ByTIC\EventDispatcher\Events;

/**
 * Trait EventTrait
 * @package ByTIC\EventDispatcher\Events
 */
trait EventTrait
{
    use Traits\HasNameTrait;
    use Traits\HasSubjectTrait;
    use Traits\HasArgumentsTrait;
    use Traits\StoppableEventTrait;

    public function __construct($subject = null, array $arguments = [])
    {
        $this->subject = $subject;
        $this->arguments = $arguments;
    }
}
