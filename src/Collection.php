<?php

namespace Isholao\Collection;

/**
 * @author Ishola O <ishola.tolu@outlook.com>
 */
class Collection implements CollectionInterface
{

    /**
     * The stored items
     *
     * @var array
     */
    protected $data = [];

    /**
     * Create a new Collection instance
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * Return all the stored items
     *
     * @return array
     */
    public function all(): array
    {
        return $this->data;
    }

    /**
     * Clear contents
     *
     */
    public function clear(): void
    {
        $this->data = [];
    }

    /**
     * Delete the contents of a given key
     *
     * @param string $key
     */
    public function clearItem(string $key): void
    {
        $this->set($key, NULL);
    }

    /**
     * Delete the given key
     *
     * @param string $keys
     */
    public function remove(string $keys): void
    {
        foreach ((array) $keys as $key)
        {
            if ($this->exists($this->data, $key))
            {
                unset($this->data[$key]);
                continue;
            }
            $items = &$this->data;
            $segments = \explode('.', $key);
            $lastSegment = \array_pop($segments);
            foreach ($segments as $segment)
            {
                if (!\array_key_exists($segment, $items) || !\is_array($items[$segment]))
                {
                    continue 2;
                }
                $items = &$items[$segment];
            }
            unset($items[$lastSegment]);
        }
    }

    /**
     * Checks if the given key exists in the provided array.
     *
     * @param  array      $array Array to validate
     * @param  int|string $key   The key to look for
     *
     * @return bool
     */
    protected function exists(array $array, $key): bool
    {
        return \array_key_exists($key, $array);
    }

    /**
     * Return the value of a given key
     *
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    public function get(string $key, $default = NULL)
    {
        if ($this->exists($this->data, $key))
        {
            return $this->data[$key];
        }
        if (strpos($key, '.') === FALSE)
        {
            return $default;
        }
        $items = $this->data;
        foreach (\explode('.', $key) as $segment)
        {
            if (!\is_array($items) || !$this->exists($items, $segment))
            {
                return $default;
            }
            $items = &$items[$segment];
        }
        return $items;
    }

    /**
     * Check if a given key or keys exists
     *
     * @param  string $keys
     * @return bool
     */
    public function has(string $keys): bool
    {
        if (!$this->data || empty($keys))
        {
            return FALSE;
        }
        foreach ((array) $keys as $key)
        {
            $items = $this->data;
            if ($this->exists($items, $key))
            {
                continue;
            }
            foreach (\explode('.', $key) as $segment)
            {
                if (!\is_array($items) || !$this->exists($items, $segment))
                {
                    return FALSE;
                }
                $items = $items[$segment];
            }
        }
        return TRUE;
    }

    /**
     * Set a given key / value pair 
     *
     * @param string $key
     * @param mixed  $value
     */
    public function set(string $key, $value)
    {
        $items = &$this->data;
        foreach (\explode('.', $key) as $segment)
        {
            if (!isset($items[$segment]) || !\is_array($items[$segment]))
            {
                $items[$segment] = [];
            }
            $items = &$items[$segment];
        }
        $items = $value;
    }

    /*
     * --------------------------------------------------------------
     * ArrayAccess interface
     * --------------------------------------------------------------
     */

    /**
     * Check if a given key exists
     *
     * @param  int|string $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return $this->has($key);
    }

    /**
     * Return the value of a given key
     *
     * @param  int|string $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->get($key);
    }

    /**
     * Set a given value to the given key
     *
     * @param int|string|null $key
     * @param mixed           $value
     */
    public function offsetSet($key, $value)
    {
        $this->set($key, $value);
    }

    /**
     * Delete the given key
     *
     * @param int|string $key
     */
    public function offsetUnset($key)
    {
        $this->remove($key);
    }

    /**
     * Return the number of items
     *
     * @return int
     */
    public function count(): int
    {
        return \count($this->data);
    }

    /**
     * Get an iterator for the stored items
     *
     * @return \ArrayIterator
     */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->data);
    }

    /**
     * Return items
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }

}
