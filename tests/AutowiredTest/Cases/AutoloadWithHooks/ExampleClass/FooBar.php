<?php
declare(strict_types=1);

namespace AutowiredTest\Cases\AutoloadWithHooks\ExampleClass;

use Autowired\Attribute\BeforeConstruct;

class FooBar
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
    public static function onBeforeInstance(): FooBar
    {
        if (self::$instance === null) {
            self::$instance = new self(400);
        }

        return self::$instance;
    }
}
