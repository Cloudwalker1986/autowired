<?php
declare(strict_types=1);

namespace Autowired\Handler;

use Autowired\Attribute\AfterConstruct;
use ReflectionClass;
use ReflectionException;

class AfterConstructHandler implements CustomHandlerInterface
{
    /**
     * @throws ReflectionException
     */
    public function handle(string|object $object, array $arguments = []): null|object
    {
        $reflection = new ReflectionClass($object);

        foreach ($reflection->getMethods() as $method) {
            if (!$method->isPublic()) {
                continue;
            }
            $attributes = $method->getAttributes();
            foreach ($attributes as $attribute) {

                $attrInstance = $attribute->newInstance();

                if ($attrInstance instanceof AfterConstruct) {
                    $object->{$method->getName()}();
                }
            }
        }

        return null;
    }
}
