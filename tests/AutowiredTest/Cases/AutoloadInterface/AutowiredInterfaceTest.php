<?php
declare(strict_types=1);

namespace AutowiredTest\Cases\AutoloadInterface;

use Autowired\Autowired;
use Autowired\DependencyContainer;
use Autowired\Exception\InvalidArgumentException;
use Autowired\Handler\InterfaceHandler;
use AutowiredTest\Cases\AutoloadInterface\ExampleClass\AutowiredInterfaceWithInterfaceHandler;
use AutowiredTest\Cases\AutoloadInterface\ExampleClass\AutowiredInterfaceWithoutTypeDeclaration;
use AutowiredTest\Cases\AutoloadInterface\ExampleClass\AutowiredInterfaceWithTypeDeclaration;
use AutowiredTest\Cases\AutoloadInterface\ExampleClass\FooBar;
use PHPUnit\Framework\TestCase;

class AutowiredInterfaceTest extends TestCase
{
    private DependencyContainer $container;

    protected function setUp(): void
    {
        $this->container = DependencyContainer::getInstance();
        parent::setUp();
    }

    protected function tearDown(): void
    {
        $this->container->flush();
        parent::tearDown();
    }

    /**
     * @test
     */
    public function autowiredClassUsingInterfaceSuccess(): void
    {
        $bar = $this->container->get(AutowiredInterfaceWithTypeDeclaration::class);

        static::assertEquals('Got injected via an interface', $bar->getFoo()->getMessage());
    }

    /**
     * @test
     */
    public function autowiredClassUsingInterfaceWithInterfaceHandler(): void
    {
        $this->container->addInterfaceHandler(
            new class implements InterfaceHandler {
                public function autowire(Autowired $autowiredAttribute, \ReflectionClass $typed): string
                {
                    return FooBar::class;
                }
            }
        );
        $bar = $this->container->get(AutowiredInterfaceWithInterfaceHandler::class);

        static::assertEquals('Got injected via an interface handler', $bar->getFoo()->getMessage());
    }

    /**
     * @test
     */
    public function autowiredClassUsingInterfaceFailure(): void
    {
        $this->expectExceptionMessage('It is not possible to initialize a pure interface.');
        $this->expectException(InvalidArgumentException::class);
        $bar = $this->container->get(AutowiredInterfaceWithoutTypeDeclaration::class);
    }
}
