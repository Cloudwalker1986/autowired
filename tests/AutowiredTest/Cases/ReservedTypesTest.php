<?php
declare(strict_types=1);

namespace AutowiredTest\Cases;

use Autowired\ReservedTypes;
use PHPUnit\Framework\TestCase;

class ReservedTypesTest extends TestCase
{
    /**
     * @test
     * @dataProvider dataProviderTestCases
     */
    public function validateCases(string $type, bool $expected): void
    {
        $result = ReservedTypes::isReservedType($type);
        $this->assertEquals($expected, $result);
    }

    public function dataProviderTestCases(): array
    {
        return [
            'invalid' => [
                'type' => 'helloWorld',
                'expected' => false,
            ],
            'valid #1' => [
                'type' => 'string',
                'expected' => true,
            ],
            'valid #2' => [
                'type' => 'array',
                'expected' => true,
            ],
            'valid #3' => [
                'type' => 'stdClass',
                'expected' => true,
            ],
            'valid #4' => [
                'type' => 'int',
                'expected' => true,
            ],
            'valid #5' => [
                'type' => 'float',
                'expected' => true,
            ],
            'valid #6' => [
                'type' => 'object',
                'expected' => true,
            ],
            'valid #7' => [
                'type' => 'bool',
                'expected' => true,
            ]
        ];
    }
}
