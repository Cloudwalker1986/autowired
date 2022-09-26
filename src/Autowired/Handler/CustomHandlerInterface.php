<?php
declare(strict_types=1);

namespace Autowired\Handler;

interface CustomHandlerInterface
{
    public function handle(string|object $object): null|object;
}
