<?php
declare(strict_types=1);

namespace AutowiredTest\Cases\Autoload;

use Autowired\Autowired;
use Autowired\AutowiredHandler;

class Bar
{
    use AutowiredHandler;

    #[Autowired(false)]
    private FooBar $fooBar;

    public function getFooBar(): FooBar
    {
        return $this->fooBar;
    }
}
