<?php
declare(strict_types=1);

namespace AutowiredTest\Cases\AutoloadMocking;

use Autowired\Cache\CachingService;
use Autowired\DependencyContainer;
use AutowiredTest\Cases\AutoloadMocking\ExampleClass\Bar;
use AutowiredTest\Cases\AutoloadMocking\ExampleClass\Foo;
use AutowiredTest\Cases\AutoloadMocking\ExampleClass\WithConstructor;
use AutowiredTest\Cases\AutoloadMocking\ExampleClass\WithNoConstructor;
use PHPUnit\Framework\TestCase;

class AutoloadWithMockTest extends TestCase
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
    public function autoloadWithMockedClassAndDefinedArgument(): void
    {
        $mockedClass = $this->getMockBuilder(Foo::class)
            ->getMock();

        $mainClassWithMockedObject = $this->container->get(WithConstructor::class, [$mockedClass]);

        static::assertEquals($mockedClass::class, $mainClassWithMockedObject->getFoo()::class);
        static::assertNotEquals(Foo::class, $mainClassWithMockedObject->getFoo()::class);
        static::assertEquals(Bar::class, $mainClassWithMockedObject->getBar()::class);
    }

    /**
     * @test
     */
    public function autoloadWithMockedClassAndWithoutDefinedArgument(): void
    {
        $mockedClass = $this->getMockBuilder(Foo::class)
            ->getMock();

        $this->container->set(Foo::class, $mockedClass);
        $mainClassWithMockedObject = $this->container->get(WithNoConstructor::class);

        static::assertEquals($mockedClass::class, $mainClassWithMockedObject->getFoo()::class);
        static::assertNotEquals(Foo::class, $mainClassWithMockedObject->getFoo()::class);
        static::assertEquals(Bar::class, $mainClassWithMockedObject->getBar()::class);
    }
}
