<?php
declare(strict_types=1);

namespace Autowired\Utils;

class ListCollection implements Collection
{
    private array $collection = [];

    public function add(float|object|int|array|string $value): Collection
    {
        $this->collection[] = $value;
        return $this;
    }

    public function getByIndex(int $key): object
    {
        if (!isset($this->collection[$key])) {
            throw new \InvalidArgumentException(
                sprintf('Undefined collection index "%s"', $key));
        }

        return $this->collection[$key];
    }

    public function count(): int
    {
        return count($this->collection);
    }

    public function next(): void
    {
        next($this->collection);
    }

    public function rewind(): void
    {
        reset($this->collection);
    }

    public function flush(): void
    {
        $this->collection = [];
    }

    public function get(): object|bool
    {
        return current($this->collection);
    }
}
