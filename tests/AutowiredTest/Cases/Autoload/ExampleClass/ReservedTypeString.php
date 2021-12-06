<?php
declare(strict_types=1);

namespace AutowiredTest\Cases\Autoload\ExampleClass;

use Autowired\Autowired;

class ReservedTypeString
{
    #[Autowired]
    private string $value;
}
