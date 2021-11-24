<?php
declare(strict_types=1);

namespace AutowiredTest\Cases\AutoloadWithHooks;

use AutowiredTest\AutowireTestCase;
use AutowiredTest\Cases\AutoloadWithHooks\ExampleClass\Foo;

class AutoloadWithHooksTest extends AutowireTestCase
{
    /**
     * @test
     */
    public function afterConstructCase(): void
    {
        /** @var Foo $foo */
        $foo = $this->container->get(Foo::class);
        $this->assertEquals(1, $foo->getValue());
    }
}
