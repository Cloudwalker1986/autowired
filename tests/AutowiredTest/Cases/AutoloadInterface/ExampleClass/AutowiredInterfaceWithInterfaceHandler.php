<?php
declare(strict_types=1);

namespace AutowiredTest\Cases\AutoloadInterface\ExampleClass;

use Autowired\Autowired;
use Autowired\AutowiredHandler;

class AutowiredInterfaceWithInterfaceHandler
{
    #[Autowired(false)]
    private FooInterface $foo;

    public function getFoo(): FooInterface
    {
        return $this->foo;
    }
}
