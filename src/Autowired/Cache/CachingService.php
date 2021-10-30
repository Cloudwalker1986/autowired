<?php
declare(strict_types=1);

namespace Autowired\Cache;

final class CachingService
{
    private static ?CachingService $instance = null;

    private array $cache = [];

    public function store(mixed $class, ?string $className = null): void
    {
        $this->cache[$className ?? $class::class] = $class;
    }

    public function get(string $class)
    {
        return $this->cache[$class];
    }

    public function unset(string $className): void
    {
        unset($this->cache[$className]);
    }

    public function contains(string $class): bool
    {
        return isset($this->cache[$class]);
    }

    public function flushCache(): void
    {
        $this->cache = [];
    }

    public static function getInstance(): CachingService
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
