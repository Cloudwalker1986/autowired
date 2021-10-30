<?php
declare(strict_types=1);

namespace AutowiredTest\Cases\AutoloadInterface\ExampleClass;

class Foo implements FooInterface
{
    public function getMessage(): string
    {
        return "Got injected via an interface";
    }
}
