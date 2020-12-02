<?php
declare(strict_types=1);

namespace AutowiredTest;

use AutowiredTest\Example\Bar;
use AutowiredTest\Example\WithAutowired;
use AutowiredTest\Example\Foo;
use AutowiredTest\Example\FooBar;
use AutowiredTest\Example\Without;
use PHPUnit\Framework\TestCase;

class AutowiredTest extends TestCase
{
    /**
     * @test
     */
    public function autowiredSuccess(): void
    {
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
        $withoutAutowired = new Without();

        $this->expectExceptionMessage('Typed property AutowiredTest\Example\Without::$bar must not be accessed before initialization');
        static::assertNull($withoutAutowired->getBar());
    }

    /**
     * @test
     */
    public function noAutowiredNumberTwo(): void
    {
        $withoutAutowired = new Without();

        $this->expectExceptionMessage('Typed property AutowiredTest\Example\Without::$foo must not be accessed before initialization');
        static::assertNull($withoutAutowired->getFoo());
    }
}
