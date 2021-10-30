<?php
declare(strict_types=1);

namespace AutowiredTest\Cases\AutoloadFactory\ExampleClass;

class Foo implements FooInterface
{
    public function __construct(private string $message){}

    public function getMessage(): string
    {
        return $this->message;
    }

    public static function getInstance(): Foo
    {
        return new self("I got loaded via a factory method");
    }
}
