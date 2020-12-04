<?php
declare(strict_types=1);

namespace AutowiredTest\Cases\AutoloadInterface\Example;

use Autowired\Autowired;
use Autowired\AutowiredHandler;

class AutowiredInterfaceWithTypeDeclaration
{
    use AutowiredHandler;

    #[Autowired(cachingAllowed: true, concreteClass: Foo::class)]
    private FooInterface $foo;

    public function getFoo(): FooInterface
    {
        return $this->foo;
    }
}
