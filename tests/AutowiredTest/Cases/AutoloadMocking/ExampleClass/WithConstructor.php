<?php
declare(strict_types=1);

namespace AutowiredTest\Cases\AutoloadMocking\ExampleClass;

use Autowired\Autowired;
use Autowired\AutowiredHandler;

class WithConstructor
{
    use AutowiredHandler;

    #[Autowired]
    private ?Foo $foo;

    #[Autowired]
    private ?Bar $bar;

    public function __construct(?Foo $foo)
    {
        $this->foo = $foo;
        $this->autowired();
    }

    public function getFoo(): Foo
    {
        return $this->foo;
    }

    public function getBar(): Bar
    {
        return $this->bar;
    }
}
