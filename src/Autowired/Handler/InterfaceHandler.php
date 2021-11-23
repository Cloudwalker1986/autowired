<?php
declare(strict_types=1);

namespace Autowired\Handler;

use Autowired\Autowired;

interface InterfaceHandler
{
    public function autowire(Autowired $autowiredAttribute, \ReflectionClass $typed): string;
}
