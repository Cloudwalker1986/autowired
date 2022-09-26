<?php
declare(strict_types=1);

namespace AutowiredTest\Cases\AutoloadWithHooks\ExampleClass;

use Autowired\Attribute\BeforeConstruct;

class FooBarFoo
{
    private static $instance = null;

    private int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    #[BeforeConstruct]
    public static function onBeforeInstance(int $value): FooBarFoo
    {
        if (self::$instance === null) {
            self::$instance = new self($value);
        }

        return self::$instance;
    }

}
