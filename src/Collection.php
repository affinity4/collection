<?php
namespace Affinity4\Collection;

class Collection implements \ArrayAccess, \Iterator
{
    /**
     * @var integer
     */
    private $position = 0;
    
    /**
     * @var array
     */
    private $collection = [];

    /**
     * Constructor
     *
     * @param array $collection
     */
    public function __construct(array $collection = null)
    {
        $this->position   = 0;
        $this->collection = $collection ?? [];
    }

    // --------------------
    // Iterator
    // --------------------

    /**
     * Rewind
     */
    public function rewind(): void
    {
        $this->position = 0;
    }

    /**
     * Current
     * 
     * @return mixed
     */
    public function current()
    {
        return $this->collection[$this->position];
    }

    /**
     * Key
     *
     * @return int|string
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Prev
     */
    public function prev()
    {
        --$this->position;
    }

    /**
     * Next
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * Valid
     * 
     * @return bool
     */
    public function valid(): bool
    {
        return isset($this->collection[$this->position]);
    }

    // --------------------
    // ArrayAccess
    // --------------------

    /**
     * Offset Set
     *
     * @param int|string $offset
     * @param mixed      $value
     */
    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            if ($this->valid()) {
                $this->next();
                if (!$this->valid()) {
                    // Nothing at this position, safe to add to collection
                    $this->collection[$this->position] = $value;
                } else {
                    // Go again
                    $this->offsetSet($offset, $value);
                }
            } else {
                $this->collection[$this->position] = $value;
            }
        } else {
            if (is_int($offset)) {
                $this->position = $offset;
                $this->collection[$this->position] = $value;
            } else {
                $this->collection[$offset] = $value;
            }
        }
    }

    /**
     * Offset Get
     *
     * @param int|string $offset
     * 
     * @return mixed
     */
    public function offsetGet($offset)
    {
        if (is_int($offset)) {
            $this->position = $offset;

            return ($this->valid()) ? $this->current() : null;
        } else {
            return isset($this->collection[$offset]) ? $this->collection[$offset] : null;
        }
    }

    /**
     * Offset Exists
     * 
     * @param int|string $offset
     * 
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return isset($this->collection[$offset]);
    }

    /**
     * Offset Unset
     *
     * @param int|string $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->collection[$offset]);
    }
}
