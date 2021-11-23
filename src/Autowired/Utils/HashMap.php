<?php
declare(strict_types=1);

namespace Autowired\Utils;

class HashMap implements Map
{
    private array $map = [];

    public function add(string $key, object $value): Map
    {
        $this->map[$key] = $value;
        return $this;
    }

    public function get(string $key): object
    {
        if (!isset($this->map[$key])) {
            throw new \InvalidArgumentException(
                sprintf('Undefined map index "%s"', $key));
        }

        return $this->map[$key];
    }

    public function has(string $key): bool
    {
        return isset($this->map[$key]);
    }

    public function count(): int
    {
        return count($this->map);
    }

    public function next(): void
    {
        next($this->map);
    }

    public function rewind(): void
    {
        reset($this->map);
    }

    public function flush(): void
    {
        $this->map = [];
    }
}
