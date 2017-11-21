<?php

namespace Isholao\Collection;

/**
 * @author Ishola O <ishola.tolu@outlook.com>
 */
interface CollectionInterface extends \ArrayAccess, \Countable, \IteratorAggregate
{

    /**
     * Return all the stored items
     *
     * @return array
     */
    public function all(): array;

    /**
     * Clear contents
     *
     */
    public function clear(): void;

    /**
     * Delete the contents of a given key
     *
     * @param string $key
     */
    public function clearItem(string $key): void;

    /**
     * Delete the given key
     *
     * @param string $keys
     */
    public function remove(string $keys): void;

    /**
     * Return the value of a given key
     *
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    public function get(string $key, $default = NULL);

    /**
     * Check if a given key or keys exists
     *
     * @param  string $keys
     * @return bool
     */
    public function has(string $keys): bool;

    /**
     * Set a given key / value pair 
     *
     * @param string $key
     * @param mixed  $value
     */
    public function set(string $key, $value);

    /**
     * Return the number of items
     *
     * @return int
     */
    public function count(): int;

    /**
     * Get an iterator for the stored items
     *
     * @return \ArrayIterator
     */
    public function getIterator(): \Traversable;

    /**
     * Return items
     *
     * @return array
     */
    public function toArray(): array;
}
