<?php

abstract class Aggregate implements ArrayAccess, Countable, IteratorAggregate
{
    protected $items = array();

    public function __construct(array $items = array())
    {
        $this->items = $items;
    }

    public function has($key)
    {
        return array_key_exists($key, $this->items);
    }

    public function get($key, $default = null)
    {
        if (array_key_exists($key, $this->items)) {
            return $this->items[$key];
        }

        return $default;
    }

    public function all()
    {
        return $this->items;
    }

    public function put($key, $value)
    {
        $this->items[$key] = $value;
    }

    public function first()
    {
        return count($this->items) > 0 ? reset($this->items) : null;
    }

    public function last()
    {
        return count($this->items) > 0 ? end($this->items) : null;
    }

    public function shift()
    {
        return array_shift($this->items);
    }

    public function push($value)
    {
        array_unshift($this->items, $value);
    }

    public function pop()
    {
        return array_pop($this->items);
    }

    public function forget($key)
    {
        unset($this->items[$key]);
    }

    public function isEmpty()
    {
        return empty($this->items);
    }

    public function offsetExists($key)
    {
        return array_key_exists($key, $this->items);
    }

    public function offsetGet($key)
    {
        return $this->items[$key];
    }

    public function offsetSet($key, $value)
    {
        if (is_null($key)) {
            $this->items[] = $value;
        } else {
            $this->items[$key] = $value;
        }
    }

    public function offsetUnset($key)
    {
        unset($this->items[$key]);
    }

    public function count()
    {
        return count($this->items);
    }

    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    public function __toString()
    {
        return json_encode($this->items);
    }
}