<?php
declare(strict_types=1);


namespace AutowiredTest\Cases\AutoloadCaching\ExampleClass;


use Autowired\Autowired;
use Autowired\AutowiredHandler;
use DateTime;

class FooWithCaching
{
    #[Autowired]
    private DateTime $datetime;
}
