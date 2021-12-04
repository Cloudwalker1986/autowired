<?php
declare(strict_types=1);

namespace AutowiredTest\Cases\Autoload;

use Autowired\Exception\InvalidArgumentException;
use AutowiredTest\AutowireTestCase;
use AutowiredTest\Cases\Autoload\ExampleClass\Bar;
use AutowiredTest\Cases\Autoload\ExampleClass\Foo;
use AutowiredTest\Cases\Autoload\ExampleClass\FooBar;
use AutowiredTest\Cases\Autoload\ExampleClass\ReservedTypeArray;
use AutowiredTest\Cases\Autoload\ExampleClass\ReservedTypeBool;
use AutowiredTest\Cases\Autoload\ExampleClass\ReservedTypeFloat;
use AutowiredTest\Cases\Autoload\ExampleClass\ReservedTypeInt;
use AutowiredTest\Cases\Autoload\ExampleClass\ReservedTypeObject;
use AutowiredTest\Cases\Autoload\ExampleClass\ReservedTypeStdClass;
use AutowiredTest\Cases\Autoload\ExampleClass\ReservedTypeString;
use AutowiredTest\Cases\Autoload\ExampleClass\WithAutowired;
use AutowiredTest\Cases\Autoload\ExampleClass\WithoutAutowired;

class AutowiredTest extends AutowireTestCase
{
    /**
     * @test
     */
    public function autowiredSuccess(): void
    {
        $autowired = $this->container->get(WithAutowired::class);

        static::assertEquals(Foo::class, $autowired->getFoo()::class);
        static::assertEquals(Bar::class, $autowired->getBar()::class);
        static::assertEquals(FooBar::class, $autowired->getBar()->getFooBar()::class);
    }

    /**
     * @test
     */
    public function noAutowiredNumberOne(): void
    {
        $withoutAutowired = $this->container->get(WithoutAutowired::class);
        $this->expectExceptionMessage('Typed property AutowiredTest\Cases\Autoload\ExampleClass\WithoutAutowired::$foo must not be accessed before initialization');
        static::assertNull($withoutAutowired->getFoo());
    }

    /**
     * @test
     */
    public function noAutowiredNumberTwo(): void
    {
        $withoutAutowired = $this->container->get(WithoutAutowired::class);

        $this->expectExceptionMessage('Typed property AutowiredTest\Cases\Autoload\ExampleClass\WithoutAutowired::$foo must not be accessed before initialization');
        static::assertNull($withoutAutowired->getFoo());
    }

    /**
     * @test
     */
    public function autowiredScalarTypeString(): void
    {
        $this->expectExceptionMessage("It is not possible to initialize a reserved type.");
        $this->expectException(InvalidArgumentException::class);
        $this->container->get(ReservedTypeString::class);
    }

    /**
     * @test
     */
    public function autowiredScalarTypeArray(): void
    {
        $this->expectExceptionMessage("It is not possible to initialize a reserved type.");
        $this->expectException(InvalidArgumentException::class);
        $this->container->get(ReservedTypeArray::class);
    }

    /**
     * @test
     */
    public function autowiredScalarTypeInt(): void
    {
        $this->expectExceptionMessage("It is not possible to initialize a reserved type.");
        $this->expectException(InvalidArgumentException::class);
        $this->container->get(ReservedTypeInt::class);
    }

    /**
     * @test
     */
    public function autowiredScalarTypeBool(): void
    {
        $this->expectExceptionMessage("It is not possible to initialize a reserved type.");
        $this->expectException(InvalidArgumentException::class);
        $this->container->get(ReservedTypeBool::class);
    }

    /**
     * @test
     */
    public function autowiredScalarTypeStdClass(): void
    {
        $this->expectExceptionMessage("It is not possible to initialize a reserved type.");
        $this->expectException(InvalidArgumentException::class);
        $this->container->get(ReservedTypeStdClass::class);
    }

    /**
     * @test
     */
    public function autowiredScalarTypeFloat(): void
    {
        $this->expectExceptionMessage("It is not possible to initialize a reserved type.");
        $this->expectException(InvalidArgumentException::class);
        $this->container->get(ReservedTypeFloat::class);
    }

    /**
     * @test
     */
    public function autowiredScalarTypeObject(): void
    {
        $this->expectExceptionMessage("It is not possible to initialize a reserved type.");
        $this->expectException(InvalidArgumentException::class);
        $this->container->get(ReservedTypeObject::class);
    }
}
