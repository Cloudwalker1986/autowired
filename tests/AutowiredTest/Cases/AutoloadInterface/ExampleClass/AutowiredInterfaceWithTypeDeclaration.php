<?php
declare(strict_types=1);

namespace AutowiredTest\Cases\AutoloadInterface\ExampleClass;

use Autowired\Autowired;
use Autowired\AutowiredHandler;

class AutowiredInterfaceWithTypeDeclaration
{
    #[Autowired(cachingAllowed: false, concreteClass: Foo::class)]
    private FooInterface $foo;

    public function getFoo(): FooInterface
    {
        return $this->foo;
    }
}
