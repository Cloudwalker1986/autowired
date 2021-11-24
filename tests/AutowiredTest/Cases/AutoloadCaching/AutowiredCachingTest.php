<?php
declare(strict_types=1);

namespace AutowiredTest\Cases\AutoloadCaching;

use AutowiredTest\AutowireTestCase;
use AutowiredTest\Cases\AutoloadCaching\ExampleClass\FooWithCaching;
use AutowiredTest\Cases\AutoloadCaching\ExampleClass\FooWithoutCaching;

class AutowiredCachingTest extends AutowireTestCase
{
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
