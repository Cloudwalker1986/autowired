<?php
declare(strict_types=1);

namespace AutowiredTest\Cases\Autoload\ExampleClass;

use Autowired\Autowired;

class ReservedTypeStdClass
{
    #[Autowired]
    private \stdClass $value;
}
