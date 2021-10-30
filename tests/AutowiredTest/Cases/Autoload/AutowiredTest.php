<?php
declare(strict_types=1);

namespace AutowiredTests\Cases\Autoload;

use Autowired\Autowired;
use Autowired\AutowiredHandler;
use Autowired\Exception\InvalidArgumentException;
use AutowiredTest\Cases\Autoload\ExampleClass\Bar;
use AutowiredTest\Cases\Autoload\ExampleClass\Foo;
use AutowiredTest\Cases\Autoload\ExampleClass\FooBar;
use AutowiredTest\Cases\Autoload\ExampleClass\WithAutowired;
use AutowiredTest\Cases\Autoload\ExampleClass\WithoutAutowired;
use PHPUnit\Framework\TestCase;

class AutowiredTest extends TestCase
{
    /**
     * @test
     */
    public function autowiredSuccess(): void
    {
        $autowired = new WithAutowired();

        static::assertEquals(Foo::class, $autowired->getFoo()::class);
        static::assertEquals(Bar::class, $autowired->getBar()::class);
        static::assertEquals(FooBar::class, $autowired->getBar()->getFooBar()::class);
    }

    /**
     * @test
     */
    public function noAutowiredNumberOne(): void
    {
        $withoutAutowired = new WithoutAutowired();

        $this->expectExceptionMessage('Typed property AutowiredTest\Cases\Autoload\ExampleClass\WithoutAutowired::$bar must not be accessed before initialization');
        static::assertNull($withoutAutowired->getBar());
    }

    /**
     * @test
     */
    public function noAutowiredNumberTwo(): void
    {
        $withoutAutowired = new WithoutAutowired();

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
        new class {

            use AutowiredHandler;

            #[Autowired]
            private string $type;
        };
    }

    /**
     * @test
     */
    public function autowiredScalarTypeArray(): void
    {
        $this->expectExceptionMessage("It is not possible to initialize a reserved type.");
        $this->expectException(InvalidArgumentException::class);
        new class {

            use AutowiredHandler;

            #[Autowired]
            private array $type;
        };
    }

    /**
     * @test
     */
    public function autowiredScalarTypeInt(): void
    {
        $this->expectExceptionMessage("It is not possible to initialize a reserved type.");
        $this->expectException(InvalidArgumentException::class);
        new class {

            use AutowiredHandler;

            #[Autowired]
            private int $type;
        };
    }

    /**
     * @test
     */
    public function autowiredScalarTypeBool(): void
    {
        $this->expectExceptionMessage("It is not possible to initialize a reserved type.");
        $this->expectException(InvalidArgumentException::class);
        new class {

            use AutowiredHandler;

            #[Autowired]
            private bool $type;
        };
    }

    /**
     * @test
     */
    public function autowiredScalarTypeStdClass(): void
    {
        $this->expectExceptionMessage("It is not possible to initialize a reserved type.");
        $this->expectException(InvalidArgumentException::class);
        new class {

            use AutowiredHandler;

            #[Autowired]
            private \stdClass $type;
        };
    }

    /**
     * @test
     */
    public function autowiredScalarTypeFloat(): void
    {
        $this->expectExceptionMessage("It is not possible to initialize a reserved type.");
        $this->expectException(InvalidArgumentException::class);
        new class {

            use AutowiredHandler;

            #[Autowired]
            private float $type;
        };
    }

    /**
     * @test
     */
    public function autowiredScalarTypeObject(): void
    {
        $this->expectExceptionMessage("It is not possible to initialize a reserved type.");
        $this->expectException(InvalidArgumentException::class);
        new class {

            use AutowiredHandler;

            #[Autowired]
            private object $type;
        };
    }
}
