<?php
declare(strict_types=1);

namespace AutowiredTest\Cases\AutoloadFactory\ExampleClass;

interface FooInterface
{
    public function getMessage(): string;

    public static function getInstance(): Foo;
}
