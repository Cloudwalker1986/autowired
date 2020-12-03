<?php
declare(strict_types=1);

namespace Autowired\Cache;

final class CachingService
{
    private static ?CachingService $instance = null;

    private array $cache = [];

    public function store(mixed $class): void
    {
        $this->cache[$class::class] = $class;
    }

    public function get(mixed $class)
    {
        return $this->cache[$class::class];
    }

    public function contains(mixed $class): bool
    {
        return isset($this->cache[$class::class]);
    }

    public static function getInstance(): CachingService
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
