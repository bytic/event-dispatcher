<?php

namespace ByTIC\EventDispatcher\Listeners\Collections;

use ByTIC\EventDispatcher\Listeners\ListenerInterface;
use IteratorAggregate;

/**
 * Class PriorityListenerCollection
 * @package ByTIC\EventDispatcher\Listeners\Collections
 */
class PriorityListenerCollection implements IteratorAggregate
{
    /**
     * @var ListenerInterface[]
     *
     * An indexed array of arrays of Item entries. The key is the priority, the value is an array of Items.
     */
    protected $items = [];

    /**
     * @var ListenerInterface[]
     *
     * A list of the items in the collection indexed by ID. Order is undefined.
     */
    protected $itemLookup = [];

    /**
     * @var bool
     */
    protected $sorted = false;

    /**
     * @param $item
     * @param int $priority
     * @param string|null $id
     * @return string
     */
    public function addItem($item, int $priority = 0, string $id = null)
    {
        $id = $this->enforceUniqueId($id);

        $this->items[$priority][] = $item;
        $this->itemLookup[$id] = $item;

        $this->sorted = false;

        return $id;
    }


    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        if (!$this->sorted) {
            krsort($this->items);
            $this->sorted = true;
        }

        foreach ($this->items as $itemList) {
            yield from $itemList;
        }
    }


    /**
     * Ensures a unique ID for all items in the collection.
     *
     * @param string|null $id
     *   The proposed ID of an item, or null to generate a random string.
     * @return string
     *   A confirmed unique ID string.
     */
    protected function enforceUniqueId(?string $id): string
    {
        $candidateId = $id ?? uniqid('', true);
        $counter = 1;
        while (isset($this->itemLookup[$candidateId])) {
            $candidateId = $id . '-' . $counter++;
        }
        return $candidateId;
    }
}
