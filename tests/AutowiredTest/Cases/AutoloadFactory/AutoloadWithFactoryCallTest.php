<?php
declare(strict_types=1);

namespace AutowiredTest\Cases\AutoloadFactory;

use AutowiredTest\AutowireTestCase;
use AutowiredTest\Cases\AutoloadFactory\ExampleClass\FooWithFactory;

class AutoloadWithFactoryCallTest extends AutowireTestCase
{
    /**
     * @test
     */
    public function autowiredFooWithFactory(): void
    {
        $foo = $this->container->get(FooWithFactory::class);

        static::assertEquals('I got loaded via a factory method', $foo->getFoo()->getMessage());
        static::assertEquals('I got loaded via a factory method', $foo->getFooWithInterface()->getMessage());
    }
}
