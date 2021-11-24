<?php
declare(strict_types=1);

namespace AutowiredTest;

use Autowired\DependencyContainer;
use PHPUnit\Framework\TestCase;

class AutowireTestCase extends TestCase
{
    protected DependencyContainer $container;

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
}
