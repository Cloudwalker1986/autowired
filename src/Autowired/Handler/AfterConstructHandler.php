<?php
declare(strict_types=1);

namespace Autowired\Handler;

use Autowired\Attribute\AfterConstruct;

class AfterConstructHandler implements CustomHandlerInterface
{
    public function handle(object $object): void
    {
        $reflection = new \ReflectionClass($object);

        foreach ($reflection->getMethods() as $method) {
            if (!$method->isPublic()) {
                continue;
            }
            $attributes = $method->getAttributes();
            foreach ($attributes as $attribute) {
                if ($attribute->newInstance() instanceof AfterConstruct) {
                    $object->{$method->getName()}();
                }
            }
        }
    }
}
