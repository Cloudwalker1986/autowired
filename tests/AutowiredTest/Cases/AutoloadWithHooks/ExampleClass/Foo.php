<?php
declare(strict_types=1);

namespace AutowiredTest\Cases\AutoloadWithHooks\ExampleClass;

use Autowired\Attribute\AfterConstruct;
use Autowired\Autowired;

class Foo
{
    private int $value = 0;

    #[Autowired]
    private Bar $bar;

    #[AfterConstruct]
    public function hook(): void
    {
        $this->value++;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
