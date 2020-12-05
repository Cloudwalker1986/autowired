<?php
declare(strict_types=1);

namespace AutowiredTest\Cases\AutoloadFactory;

use AutowiredTest\Cases\AutoloadFactory\ExampleClass\FooWithFactory;
use PHPUnit\Framework\TestCase;

class AutoloadWithFactoryCallTest extends TestCase
{
    /**
     * @test
     */
    public function autowiredFooWithFactory(): void
    {
        $foo = new FooWithFactory();

        static::assertEquals('I got loaded via a factory method', $foo->getFoo()->getMessage());
        static::assertEquals('I got loaded via a factory method', $foo->getFooWithInterface()->getMessage());
    }
}
