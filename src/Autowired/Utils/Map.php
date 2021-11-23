<?php
declare(strict_types=1);

namespace Autowired\Utils;

interface Map
{
    /**
     * Add a new element to the with a key to the map
     */
    public function add(string $key, object $value): Map;

    /**
     * Returns an element which maps to the provided key
     *
     * @throws \InvalidArgumentException
     */
    public function get(string $key): object;

    /**
     * Returns bool true on key exists already and false when the key does not exsist
     */
    public function has(string $key): bool;

    /**
     * Returns the count of all added elements
     */
    public function count(): int;

    /**
     * Moves the pointer of the map to the next element
     */
    public function next(): void;

    /**
     * Move the pointer back to the first element
     */
    public function rewind(): void;

    /**
     * Erase the map elements
     */
    public function flush(): void;
}
