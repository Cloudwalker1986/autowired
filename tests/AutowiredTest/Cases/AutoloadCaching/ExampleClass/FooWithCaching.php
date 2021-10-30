<?php
declare(strict_types=1);


namespace AutowiredTest\Cases\AutoloadCaching\ExampleClass;


use Autowired\Autowired;
use Autowired\AutowiredHandler;
use DateTime;

class FooWithCaching
{
    use AutowiredHandler;

    #[Autowired]
    private DateTime $datetime;
}
