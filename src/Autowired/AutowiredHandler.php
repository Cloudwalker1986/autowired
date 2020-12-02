<?php
declare(strict_types=1);

namespace Autowired;

trait AutowiredHandler
{
    public function __construct()
    {
        $this->autowired();
    }

    private function autowired(): void
    {
        $reference = new \ReflectionClass($this);

        foreach ($reference->getProperties() as $property) {
            if ($property->getAttributes(Autowired::class)) {
                foreach ($property->getAttributes(Autowired::class) as $attribute) {
                    $name = $property->getName();
                    $className = $property->getType()->getName();
                    $this->$name = new $className();
                }
            }
        }
    }
}
