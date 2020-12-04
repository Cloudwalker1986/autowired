<?php
declare(strict_types=1);

namespace AutowiredTest\Cases\AutoloadInterface\Example;

use Autowired\Autowired;
use Autowired\AutowiredHandler;

class AutowiredInterfaceWithoutTypeDeclaration
{
    use AutowiredHandler;

    #[Autowired]
    private FooInterface $foo;
}
