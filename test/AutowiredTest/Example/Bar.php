<?php
declare(strict_types=1);

namespace AutowiredTest\Example;

use Autowired\Autowired;
use Autowired\AutowiredHandler;

class Bar
{
    use AutowiredHandler;

    #[Autowired]
    private FooBar $fooBar;

    public function getFooBar(): FooBar
    {
        return $this->fooBar;
    }
}
