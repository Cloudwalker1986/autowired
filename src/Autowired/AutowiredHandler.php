<?php
declare(strict_types=1);

namespace Autowired;

use Autowired\Cache\CachingService;
use Autowired\Exception\InterfaceArgumentException;
use Autowired\Exception\InvalidArgumentException;
use JetBrains\PhpStorm\Deprecated;
use ReflectionClass;
use ReflectionException;
use ReflectionNamedType;
use ReflectionProperty;
use Throwable;

#[Deprecated('This handler will be removed in version 2.0.', since: '8.1')]
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

    /**
     * @throws InterfaceArgumentException
     * @throws ReflectionException
     */
    public function __construct()
    {
        $this->autowired();
    }

    /**
     * @throws InterfaceArgumentException
     * @throws ReflectionException
     */
    protected function autowired(): void
    {
        $reference = new ReflectionClass($this);

        $cache = CachingService::getInstance();

        foreach ($reference->getProperties() as $property) {
            if (!$this->propertyAlreadyInitialized($property) && $property->getAttributes(Autowired::class)) {
                $this->assignObjectToReference($property, $cache);
            }
        }
    }

    private function propertyAlreadyInitialized(ReflectionProperty $property): bool
    {
        $name = $property->getName();

        $e = null;

        try {
            $this->$name;
        } catch (Throwable $e) {
        } finally {
            return $e === null;
        }
    }

    private function withCache(string|object $class, CachingService $cache, string $name): void
    {
        $className = (is_string($class) ? $class : $class::class);
        if ($cache->contains($className)) {
            $this->$name = $cache->get($className);
        } else {
            $cache->store($class);
            $this->$name = $class;
        }
    }

    /**
     * @param ReflectionProperty $property
     * @param CachingService $cache
     * @throws ReflectionException|InterfaceArgumentException
     */
    protected function assignObjectToReference(ReflectionProperty $property, CachingService $cache): void
    {
        foreach ($property->getAttributes(Autowired::class) as $attribute) {

            /** @var Autowired $autowiredAttribute */
            $autowiredAttribute = $attribute->newInstance();

            $type = $this->getObjectType($property, $autowiredAttribute);

            $name = $property->getName();
            if ($autowiredAttribute->getConcreteClass() !== null) {

                if ($cache->contains($autowiredAttribute->getConcreteClass())) {
                    $class = $cache->get($autowiredAttribute->getConcreteClass());
                    $method = $autowiredAttribute->getStaticFunction();
                    $this->$name = $class::$method();
                    continue;
                }

                if ($cache->contains($type)) {
                    $this->$name = $cache->get($type);
                    continue;
                }
            }

            if ($autowiredAttribute->hasStaticFunction()) {
                $method = $autowiredAttribute->getStaticFunction();
                $class = $type::$method();
            } else {
                $class = new $type();
            }

            $this->handleCustomAttributes($class);

            if ($autowiredAttribute->shouldCache()) {
                $this->withCache($class, $cache, $name);
                continue;
            }
            $this->$name = $class;
        }
    }

    /**
     * @throws InterfaceArgumentException
     * @throws ReflectionException
     */
    protected function getObjectType(ReflectionProperty $property, Autowired $autowiredAttribute): string
    {

        /** @var ReflectionNamedType $classType */
        $classType = $property->getType();

        if ($classType === null) {
            throw new InvalidArgumentException('The type is missing and can´t be autowired');
        }
        $type = $classType->getName();

        if (in_array($type, $this->reservedTypes, true)) {
            throw new InvalidArgumentException('It is not possible to initialize a reserved type.');
        }

        $typed = new ReflectionClass($type);

        if ($typed->isInterface()) {
            $type = $this->handleInterface($autowiredAttribute, $typed);
        } else {
            $type = $typed->getName();
        }

        return $type;
    }

    /**
     * @throws InterfaceArgumentException
     */
    protected function handleInterface(Autowired $autowiredAttribute, \ReflectionClass $typed): string
    {
        $className = $autowiredAttribute->getConcreteClass();
        if (!$className) {
            throw new InterfaceArgumentException('It is not possible to initialize a pure interface.');
        }

        return $className;
    }

    protected function getReservedParameterTypes(): array
    {
        return $this->reservedTypes;
    }

    protected function handleCustomAttributes(Object $class): void {}
}
