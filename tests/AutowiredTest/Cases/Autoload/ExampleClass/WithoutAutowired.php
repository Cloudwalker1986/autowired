<?php
declare(strict_types=1);

namespace AutowiredTest\Cases\Autoload\ExampleClass;

use Autowired\Autowired;

class WithoutAutowired
{
    private ?Foo $foo;

    #[Autowired(false)]
    private ?Bar $bar;

    public function getFoo(): ?Foo
    {
        return $this->foo;
    }

    public function getBar(): ?Bar
    {
        return $this->bar;
    }
}
