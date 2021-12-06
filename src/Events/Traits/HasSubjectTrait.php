<?php

namespace ByTIC\EventDispatcher\Events\Traits;

use ByTIC\EventDispatcher\Events\EventInterface;

/**
 * Trait HasNameTrait
 * @package ByTIC\EventDispatcher\Events\Traits
 */
trait HasSubjectTrait
{
    protected $subject;

    /**
     * Getter for subject property.
     *
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }
}
