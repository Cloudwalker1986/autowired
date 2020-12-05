<?php
declare(strict_types=1);

namespace AutowiredTest\Cases\AutoloadFactory\ExampleClass;

use Autowired\Autowired;
use Autowired\AutowiredHandler;

class FooWithFactory
{
    use AutowiredHandler;

    #[Autowired(staticFunction: "getInstance")]
    private Foo $foo;

    #[Autowired(concreteClass: Foo::class, staticFunction: "getInstance")]
    private FooInterface $fooWithInterface;

    public function getFoo(): Foo
    {
        return $this->foo;
    }

    public function getFooWithInterface(): FooInterface
    {
        return $this->fooWithInterface;
    }
}
