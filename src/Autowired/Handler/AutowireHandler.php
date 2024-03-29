<?php
declare(strict_types=1);

namespace Autowired\Handler;

use Autowired\Autowired;
use Autowired\DependencyContainer;
use Autowired\Exception\InterfaceArgumentException;
use Autowired\Exception\InvalidArgumentException;
use Autowired\ReservedTypes;
use ReflectionClass;
use ReflectionException;
use ReflectionNamedType;
use ReflectionProperty;
use Throwable;
use Autowired\Utils\Collection;
use Autowired\Utils\ListCollection;

class AutowireHandler
{
    private DependencyContainer $container;

    private Collection $customHandlers;

    /**
     * @param DependencyContainer $container
     */
    public function __construct(DependencyContainer $container)
    {
        $this->container = $container;
        $this->customHandlers = new ListCollection();
    }

    public function addCustomHandler(CustomHandlerInterface $handler): self
    {
        $this->customHandlers->add($handler);

        return $this;
    }

    /**
     * @throws InterfaceArgumentException
     * @throws ReflectionException
     */
    public function autowire(object $object): void
    {
        $reference = new ReflectionClass($object);

        foreach ($reference->getProperties() as $property) {
            if (!$this->propertyAlreadyInitialized($property, $object) && $property->getAttributes(Autowired::class)) {
                $this->assignObjectToReference($property, $object);
            }
        }

        /** @var CustomHandlerInterface $handler */
        while($handler = $this->customHandlers->get()) {
            $this->customHandlers->next();
            $handler->handle($object);
        }
        $this->customHandlers->rewind();
    }

    private function propertyAlreadyInitialized(ReflectionProperty $property, object $object): bool
    {
        $name = $property->getName();

        $e = null;

        try {
            $e = $property->getValue($object);
        } catch (Throwable $e) {
            $e = null;
        } finally {
            return $e !== null;
        }
    }

    /**
     * @throws ReflectionException
     * @throws InterfaceArgumentException
     */
    protected function assignObjectToReference(ReflectionProperty $property, object $object): void
    {
        foreach ($property->getAttributes(Autowired::class) as $attribute) {

            /** @var Autowired $autowiredAttribute */
            $autowiredAttribute = $attribute->newInstance();

            $type = $property->getType()->getName();

            if ($this->container->contains($type)) {
                $property->setValue($object, $this->container->get($type));
                continue;
            }

            $type = $this->getObjectType($property, $autowiredAttribute);

            if ($this->container->contains($type)) {
                $property->setValue($object, $this->container->get($type));
                continue;
            }

            if ($autowiredAttribute->getConcreteClass() !== null) {

                if ($this->container->contains($autowiredAttribute->getConcreteClass())) {
                    $class = $this->container->get($autowiredAttribute->getConcreteClass());
                    $method = $autowiredAttribute->getStaticFunction();
                    $property->setValue($object, $class::$method());
                    continue;
                }
            }

            if ($autowiredAttribute->hasStaticFunction()) {
                $method = $autowiredAttribute->getStaticFunction();
                $class = $type::$method();
            } else {
                $class = $this->container->get($type);
            }

            /** @var CustomHandlerInterface $handler */
            while($handler = $this->customHandlers->get()) {
                $this->customHandlers->next();
                $handler->handle($class);
            }
            $this->customHandlers->rewind();

            if ($autowiredAttribute->shouldCache()) {
                $this->container->set($class::class, $class);
            }
            $property->setValue($object, $class);
        }
    }


    /**
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

        if (ReservedTypes::isReservedType($type)) {
            throw new InvalidArgumentException('It is not possible to initialize a reserved type.');
        }

        return $this->getObject($type, $autowiredAttribute);
    }

    /**
     * @param string $type
     * @param Autowired $autowiredAttribute
     * @return string
     * @throws ReflectionException
     */
    protected function getObject(string $type, Autowired $autowiredAttribute): string
    {
        $typed = new ReflectionClass($type);
        $object = null;

        if ($typed->isInterface()) {
            if ($this->useInterfaceHandler($autowiredAttribute)) {
                $object = $this->container->getInterfaceHandler()->autowire($autowiredAttribute, $typed);
            } elseif ($this->useConcreteClass($autowiredAttribute)) {
                $object = $autowiredAttribute->getConcreteClass();
            } elseif ($this->useStaticMethod($autowiredAttribute)) {
                $concreteClass = $autowiredAttribute->getConcreteClass();
                $method = $autowiredAttribute->getStaticFunction();
                $object = call_user_func([$concreteClass, $method]);
            }

            if (empty($object)) {
                throw new InvalidArgumentException('It is not possible to initialize a pure interface.');
            }
        } else {
            $object = $typed->getName();
        }

        return $object;
    }

    private function useInterfaceHandler(Autowired $autowiredAttribute): bool
    {
        return $this->container->hasInterfaceHandler()
            && !$autowiredAttribute->hasStaticFunction()
            && !$autowiredAttribute->getConcreteClass();
    }

    private function useConcreteClass(Autowired $autowiredAttribute): bool
    {
        return !empty($autowiredAttribute->getConcreteClass());
    }

    private function useStaticMethod(Autowired $autowiredAttribute): bool
    {
        return $this->useConcreteClass($autowiredAttribute) && $autowiredAttribute->hasStaticFunction();
    }
}
