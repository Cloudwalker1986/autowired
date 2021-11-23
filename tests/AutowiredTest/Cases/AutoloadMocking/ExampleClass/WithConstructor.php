<?php
declare(strict_types=1);

namespace AutowiredTest\Cases\AutoloadMocking\ExampleClass;

use Autowired\Autowired;
use Autowired\AutowiredHandler;

class WithConstructor
{
    #[Autowired]
    private ?Foo $foo;

    #[Autowired]
    private ?Bar $bar;

    public function getFoo(): Foo
    {
        return $this->foo;
    }

    public function getBar(): Bar
    {
        return $this->bar;
    }
}
