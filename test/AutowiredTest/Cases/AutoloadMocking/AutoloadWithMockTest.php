<?php
declare(strict_types=1);

namespace AutowiredTest\Cases\AutoloadMocking;

use Autowired\Cache\CachingService;
use AutowiredTest\Cases\AutoloadMocking\ExampleClass\Bar;
use AutowiredTest\Cases\AutoloadMocking\ExampleClass\Foo;
use AutowiredTest\Cases\AutoloadMocking\ExampleClass\WithConstructor;
use AutowiredTest\Cases\AutoloadMocking\ExampleClass\WithNoConstructor;
use PHPUnit\Framework\TestCase;

class AutoloadWithMockTest extends TestCase
{
    /**
     * @test
     */
    public function autoloadWithMockedClassAndConstructor(): void
    {
        $mockedClass = $this->getMockBuilder(Foo::class)
            ->getMock();

        $mainClassWithMockedObject = new WithConstructor($mockedClass);

        static::assertEquals($mockedClass::class, $mainClassWithMockedObject->getFoo()::class);
        static::assertNotEquals(Foo::class, $mainClassWithMockedObject->getFoo()::class);
        static::assertEquals(Bar::class, $mainClassWithMockedObject->getBar()::class);
    }

    /**
     * @test
     */
    public function autoloadWithMockedClassAndWithoutConstructor(): void
    {
        $mockedClass = $this->getMockBuilder(Foo::class)
            ->getMock();

        $autowiredServiceCache = CachingService::getInstance();
        $autowiredServiceCache->store($mockedClass, Foo::class);
        $mainClassWithMockedObject = new WithNoConstructor();

        static::assertEquals($mockedClass::class, $mainClassWithMockedObject->getFoo()::class);
        static::assertNotEquals(Foo::class, $mainClassWithMockedObject->getFoo()::class);
        static::assertEquals(Bar::class, $mainClassWithMockedObject->getBar()::class);
        CachingService::getInstance()->flushCache();
    }
}
