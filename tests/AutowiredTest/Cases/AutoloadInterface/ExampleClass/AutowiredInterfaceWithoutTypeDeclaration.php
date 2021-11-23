<?php
declare(strict_types=1);

namespace AutowiredTest\Cases\AutoloadInterface\ExampleClass;

use Autowired\Autowired;
use Autowired\AutowiredHandler;

class AutowiredInterfaceWithoutTypeDeclaration
{
    #[Autowired(false)]
    private FooInterface $foo;
}
