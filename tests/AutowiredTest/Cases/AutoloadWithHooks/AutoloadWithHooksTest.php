<?php
declare(strict_types=1);

namespace AutowiredTest\Cases\AutoloadWithHooks;

use Autowired\Exception\BeforeConstructException;
use AutowiredTest\AutowireTestCase;
use AutowiredTest\Cases\AutoloadWithHooks\ExampleClass\BarFooBar;
use AutowiredTest\Cases\AutoloadWithHooks\ExampleClass\Foo;
use AutowiredTest\Cases\AutoloadWithHooks\ExampleClass\FooBar;
use AutowiredTest\Cases\AutoloadWithHooks\ExampleClass\FooBarFoo;

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

    /**
     * @test
     */
    public function beforeConstructCaseOne(): void
    {
        $this->assertEquals(0, (new FooBar(0))->getValue());
        /** @var FooBar $fooBar */
        $fooBar = $this->container->get(FooBar::class);

        $this->assertEquals(400, $fooBar->getValue());
    }

    /**
     * @test
     */
    public function beforeConstructCaseTwo(): void
    {
        /** @var FooBarFoo $fooBar */
        $fooBar = $this->container->get(FooBarFoo::class, argumentForHook: [200]);

        $this->assertEquals(200, $fooBar->getValue());
    }

    /**
     * @test
     */
    public function beforeConstructCaseThree(): void
    {
        /** @var FooBarFoo $fooBarFoo */
        $fooBarFoo = $this->container->get(FooBarFoo::class, argumentForHook: [200]);

        $this->assertEquals(200, $fooBarFoo->getValue());

        /** @var FooBarFoo $fooBarFoo */
        $fooBarFoo = $this->container->get(FooBarFoo::class, argumentForHook: [800]);

        $this->assertEquals(200, $fooBarFoo->getValue());
    }

    /**
     * @test
     */
    public function beforeConstructInvalidCase(): void
    {
        $this->expectException(BeforeConstructException::class);
        $this->expectExceptionMessage('BeforeConstruct is only allowed for public static methods.');
        $this->container->get(BarFooBar::class);
    }
}
