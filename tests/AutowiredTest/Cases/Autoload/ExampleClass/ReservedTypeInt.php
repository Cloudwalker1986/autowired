<?php
declare(strict_types=1);

namespace AutowiredTest\Cases\Autoload\ExampleClass;

use Autowired\Autowired;

class ReservedTypeInt
{
    #[Autowired]
    private int $value;
}
