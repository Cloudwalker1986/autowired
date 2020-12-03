<?php
declare(strict_types=1);

namespace Autowired;

use Autowired\Cache\CachingService;
use Autowired\Exception\InvalidArgumentException;

trait AutowiredHandler
{
    private array $reservedTypes = [
        "array",
        "string",
        "int",
        "bool",
        "float",
        "object",
        "stdClass",
    ];

    public function __construct()
    {
        $this->autowired();
    }

    protected function autowired(): void
    {
        $reference = new \ReflectionClass($this);

        $cache = CachingService::getInstance();

        foreach ($reference->getProperties() as $property) {
            if (!$this->propertyAlreadyInitialized($property) && $property->getAttributes(Autowired::class)) {
                $this->assignObjectToReference($property, $cache);
            }
        }
    }

    private function propertyAlreadyInitialized(\ReflectionProperty $property): bool
    {
        $name = $property->getName();

        try {
            $this->$name;
            return true;
        } catch (\Throwable $e) {
            return false;
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

    /**
     * @param \ReflectionProperty $property
     * @param CachingService $cache
     */
    protected function assignObjectToReference(\ReflectionProperty $property, CachingService $cache): void
    {
        foreach ($property->getAttributes(Autowired::class) as $attribute) {

            /** @var Autowired $autowiredAttribute */
            $autowiredAttribute = $attribute->newInstance();

            $type = $property->getType()->getName();

            if (in_array($type, $this->reservedTypes, true)) {
                throw new InvalidArgumentException('It is not possible to initialize a reserved type.');
            }

            $class = new $type();
            $name = $property->getName();
            if ($autowiredAttribute->shouldCache()) {
                $this->withCache($class, $cache, $name);
                continue;
            }
            $this->$name = $class;
        }
    }
}
