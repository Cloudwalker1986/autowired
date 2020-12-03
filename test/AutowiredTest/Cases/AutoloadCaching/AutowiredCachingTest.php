<?php
declare(strict_types=1);

namespace AutowiredTest\Cases\AutoloadCaching;

use PHPUnit\Framework\TestCase;

class AutowiredCachingTest extends TestCase
{
    /**
     * @test
     */
    public function caseWithCachingUsage(): void
    {
        $objectOne = new FooWithCaching();
        sleep(1);
        $objectTwo = new FooWithCaching();

        $this->assertEquals($objectTwo, $objectOne);
    }

    /**
     * @test
     */
    public function caseWithoutCachingUsage(): void
    {
        $objectOne = new FooWithoutCaching();
        sleep(1);
        $objectTwo = new FooWithoutCaching();
        $this->assertNotEquals($objectTwo, $objectOne);
    }
}
