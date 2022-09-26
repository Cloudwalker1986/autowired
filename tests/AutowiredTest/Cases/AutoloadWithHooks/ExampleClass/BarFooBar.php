<?php
declare(strict_types=1);

namespace AutowiredTest\Cases\AutoloadWithHooks\ExampleClass;

use Autowired\Attribute\BeforeConstruct;

class BarFooBar
{
    #[BeforeConstruct]
    public function invalidHookForBeforeConstruct(): void {}
}
