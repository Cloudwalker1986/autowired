<?php
declare(strict_types=1);

namespace Autowired;

use Autowired\Cache\CachingService;

trait AutowiredHandler
{
    public function __construct()
    {
        $this->autowired();
    }

    protected function autowired(): void
    {
        $reference = new \ReflectionClass($this);

        $cache = CachingService::getInstance();

        foreach ($reference->getProperties() as $property) {
            if ($property->getAttributes(Autowired::class)) {

                foreach ($property->getAttributes(Autowired::class) as $attribute) {
                    /** @var Autowired $autowiredAttribute */
                    $autowiredAttribute = $attribute->newInstance();
                    $name = $property->getName();
                    $className = $property->getType()->getName();

                    $class = new $className();
                    if ($autowiredAttribute->shouldCache()) {
                        $this->withCache($class, $cache, $name);
                        continue;
                    }
                    $this->$name = $class;
                }
            }
        }
    }

    private function withCache(mixed $class, CachingService $cache, string $name): void
    {
        if ($cache->contains($class)) {
            $this->$name = $cache->get($class);
        } else {
            $cache->store($class);
            $this->$name = $class;
        }
    }
}
