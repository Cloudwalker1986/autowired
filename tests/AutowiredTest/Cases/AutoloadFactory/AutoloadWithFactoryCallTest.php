<?php
declare(strict_types=1);

namespace AutowiredTest\Cases\AutoloadFactory;

use Autowired\DependencyContainer;
use AutowiredTest\Cases\AutoloadFactory\ExampleClass\FooWithFactory;
use PHPUnit\Framework\TestCase;

class AutoloadWithFactoryCallTest extends TestCase
{
    private DependencyContainer $container;

    protected function setUp(): void
    {
        $this->container = DependencyContainer::getInstance();
        parent::setUp();
    }

    protected function tearDown(): void
    {
        $this->container->flush();
        parent::tearDown();
    }

    /**
     * @test
     */
    public function autowiredFooWithFactory(): void
    {
        $foo = $this->container->get(FooWithFactory::class);

        static::assertEquals('I got loaded via a factory method', $foo->getFoo()->getMessage());
        static::assertEquals('I got loaded via a factory method', $foo->getFooWithInterface()->getMessage());
    }
}
