<?php
declare(strict_types=1);

namespace Autowired;

use ReflectionClass;
use RuntimeException;
use ReflectionException;
use Autowired\Utils\Map;
use Autowired\Utils\HashMap;
use Autowired\Handler\AutowireHandler;
use Autowired\Handler\InterfaceHandler;
use Autowired\Handler\AfterConstructHandler;
use Autowired\Handler\BeforeConstructHandler;
use Autowired\Handler\CustomHandlerInterface;

class DependencyContainer
{
    private static ?DependencyContainer $instance = null;

    private Map $cache;

    private ?InterfaceHandler $interfaceHandler = null;

    private AutowireHandler $autowireHandler;

    private BeforeConstructHandler $beforeConstructHandler;

    private function __construct()
    {
        $this->autowireHandler = new AutowireHandler($this);
        $this->autowireHandler->addCustomHandler(new AfterConstructHandler());
        $this->beforeConstructHandler = new BeforeConstructHandler();
        $this->cache = new HashMap();
    }

    /**
     * @throws Exception\InterfaceArgumentException
     * @throws ReflectionException
     */
    public function get(
        string $className,
        array $arguments = [],
        array $argumentForHook = []
    ): object
    {
        if ($this->cache->has($className)) {
            return $this->cache->get($className);
        }

        $object = $this->beforeConstructHandler->handle($className, $argumentForHook);

        if (empty($object)) {
            $object = new $className();
        }

        if (!empty($arguments)) {
            $this->defineArguments($arguments, $object);
        }

        $this->autowireHandler->autowire($object);

        return $object;
    }

    public function addCustomHandler(CustomHandlerInterface $handler): DependencyContainer
    {
        $this->autowireHandler->addCustomHandler($handler);

        return $this;
    }

    public function set(string $key, object $object): void
    {
        $this->cache->add($key, $object);
    }

    public function contains(string $className): bool
    {
        return $this->cache->has($className);
    }

    public function addInterfaceHandler(InterfaceHandler $handler): void
    {
        if ($this->interfaceHandler === null) {
            $this->interfaceHandler = $handler;
            return;
        }

        throw new RuntimeException('Only one interface handler can be defined.');
    }

    public function hasInterfaceHandler(): bool
    {
        return $this->interfaceHandler !== null;
    }

    public function getInterfaceHandler(): ?InterfaceHandler
    {
        return $this->interfaceHandler;
    }

    public function flush(): void
    {
        $this->cache->flush();
        $this->interfaceHandler = null;
        self::$instance = null;
    }

    public static function getInstance(): DependencyContainer
    {
        if (static::$instance === null) {
            static::$instance = new self();
        }

        return static::$instance;
    }

    private function defineArguments(array $arguments, object $object): void
    {
        $properties = (new ReflectionClass($object))->getProperties();
        foreach ($arguments as $argument) {
            foreach ($properties as $property) {
                $extends = class_parents($argument);
                if ($property->getType() instanceof $argument || isset($extends[$property->getType()->getName()])) {
                    $property->setValue($object, $argument);
                }
            }
        }
    }
}
