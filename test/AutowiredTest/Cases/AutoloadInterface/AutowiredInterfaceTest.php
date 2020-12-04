<?php
declare(strict_types=1);

namespace AutowiredTest\Cases\AutoloadInterface;

use Autowired\Exception\InterfaceArgumentException;
use AutowiredTest\Cases\AutoloadInterface\Example\AutowiredInterfaceWithoutTypeDeclaration;
use AutowiredTest\Cases\AutoloadInterface\Example\AutowiredInterfaceWithTypeDeclaration;
use PHPUnit\Framework\TestCase;

class AutowiredInterfaceTest extends TestCase
{
    /**
     * @test
     */
    public function autowiredClassUsingInterfaceSuccess(): void
    {
        $bar = new AutowiredInterfaceWithTypeDeclaration();

        static::assertEquals('Got injected via an interface', $bar->getFoo()->getMessage());
    }
    /**
     * @test
     */
    public function autowiredClassUsingInterfaceFailure(): void
    {
        $this->expectExceptionMessage('It is not possible to initialize a pure interface.');
        $this->expectException(InterfaceArgumentException::class);
        $bar = new AutowiredInterfaceWithoutTypeDeclaration();
    }
}
