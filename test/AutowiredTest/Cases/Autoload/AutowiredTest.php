<?php
declare(strict_types=1);

namespace AutowiredTest\Cases\Autoload;

use PHPUnit\Framework\TestCase;

class AutowiredTest extends TestCase
{
    /**
     * @test
     */
    public function autowiredSuccess(): void
    {
        var_export(new Example());

        $autowired = new WithAutowired();

        static::assertInstanceOf(Foo::class, $autowired->getFoo());
        static::assertInstanceOf(Bar::class, $autowired->getBar());
        static::assertInstanceOf(FooBar::class, $autowired->getBar()->getFooBar());
    }

    /**
     * @test
     */
    public function noAutowiredNumberOne(): void
    {
        $withoutAutowired = new WithoutAutowired();

        $this->expectExceptionMessage('Typed property AutowiredTest\Cases\Autoload\WithoutAutowired::$bar must not be accessed before initialization');
        static::assertNull($withoutAutowired->getBar());
    }

    /**
     * @test
     */
    public function noAutowiredNumberTwo(): void
    {
        $withoutAutowired = new WithoutAutowired();

        $this->expectExceptionMessage('Typed property AutowiredTest\Cases\Autoload\WithoutAutowired::$foo must not be accessed before initialization');
        static::assertNull($withoutAutowired->getFoo());
    }
}
