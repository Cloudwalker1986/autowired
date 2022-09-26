<?php
declare(strict_types=1);

namespace Autowired\Handler;

use Autowired\Attribute\BeforeConstruct;
use Autowired\Exception\BeforeConstructException;
use ReflectionClass;
use ReflectionException;

class BeforeConstructHandler implements CustomHandlerInterface
{
    /**
     * @throws ReflectionException
     */
    public function handle(string|object $object, array $arguments = []): null|object
    {
        $reflection = new ReflectionClass($object);

        $value = null;

        foreach ($reflection->getMethods() as $method) {
            if (!$method->isPublic()) {
                continue;
            }
            $attributes = $method->getAttributes();
            foreach ($attributes as $attribute) {

                $attrInstance = $attribute->newInstance();

                if ($attrInstance instanceof BeforeConstruct) {
                    if (!$method->isStatic()) {
                        throw new BeforeConstructException('BeforeConstruct is only allowed for public static methods.');
                    }
                    $value =  call_user_func_array([$object, $method->getName()], $arguments);
                }
            }
        }

        return $value;
    }
}
