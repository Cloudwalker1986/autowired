<?php
declare(strict_types=1);

namespace AutowiredTest\Cases\Autoload\ExampleClass;

use Autowired\Autowired;
use Autowired\AutowiredHandler;

class Bar
{
    #[Autowired(false)]
    private FooBar $fooBar;

    public function getFooBar(): FooBar
    {
        return $this->fooBar;
    }
}
