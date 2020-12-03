<?php
declare(strict_types=1);

namespace AutowiredTest\Cases\AutoloadMocking\ExampleClass;

use Autowired\Autowired;

class Foo {

    public function action(): string
    {
        return "Hello world";
    }
}
