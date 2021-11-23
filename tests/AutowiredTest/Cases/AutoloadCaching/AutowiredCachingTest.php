<?php
declare(strict_types=1);

namespace AutowiredTest\Cases\AutoloadCaching;

use Autowired\DependencyContainer;
use AutowiredTest\Cases\AutoloadCaching\ExampleClass\FooWithCaching;
use AutowiredTest\Cases\AutoloadCaching\ExampleClass\FooWithoutCaching;
use PHPUnit\Framework\TestCase;

class AutowiredCachingTest extends TestCase
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
    public function caseWithCachingUsage(): void
    {
        $objectOne = $this->container->get(FooWithCaching::class);
        sleep(1);
        $objectTwo = $this->container->get(FooWithCaching::class);

        static::assertEquals($objectTwo, $objectOne);
    }

    /**
     * @test
     */
    public function caseWithoutCachingUsage(): void
    {
        $objectOne = $this->container->get(FooWithoutCaching::class);
        sleep(1);
        $objectTwo = $this->container->get(FooWithoutCaching::class);
        static::assertNotEquals($objectTwo, $objectOne);
    }
}
