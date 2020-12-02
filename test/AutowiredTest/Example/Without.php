<?php
declare(strict_types=1);

namespace AutowiredTest\Example;

use Autowired\Autowired;

class Without
{
    private Foo $foo;

    #[Autowired]
    private Bar $bar;

    public function getFoo():? Foo
    {
        return $this->foo;
    }

    public function getBar(): ?Bar
    {
        return $this->bar;
    }
}