<?php
declare(strict_types=1);

namespace AutowiredTest\Cases\AutoloadMocking;

use AutowiredTest\AutowireTestCase;
use AutowiredTest\Cases\AutoloadMocking\ExampleClass\Bar;
use AutowiredTest\Cases\AutoloadMocking\ExampleClass\Foo;
use AutowiredTest\Cases\AutoloadMocking\ExampleClass\WithConstructor;
use AutowiredTest\Cases\AutoloadMocking\ExampleClass\WithNoConstructor;

class AutoloadWithMockTest extends AutowireTestCase
{
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
