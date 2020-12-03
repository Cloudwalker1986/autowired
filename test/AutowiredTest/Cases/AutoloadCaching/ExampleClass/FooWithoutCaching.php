<?php
declare(strict_types=1);


namespace AutowiredTest\Cases\AutoloadCaching\ExampleClass;


use Autowired\Autowired;
use Autowired\AutowiredHandler;
use DateTime;

class FooWithoutCaching
{
    use AutowiredHandler;

    #[Autowired(false)]
    private DateTime $datetime;
}
