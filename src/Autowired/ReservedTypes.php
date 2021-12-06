<?php
declare(strict_types=1);

namespace Autowired;

enum ReservedTypes: string
{
    case ARRAY = 'array';
    case STRING = 'string';
    case BOOLEAN = 'bool';
    case INT = 'int';
    case FLOAT = 'float';
    case OBJECT = 'object';
    case STDCLASS = 'stdClass';

    public static function isReservedType(string $type): bool
    {
        return match ($type) {
            self::ARRAY->value,
            self::STRING->value,
            self::BOOLEAN->value,
            self::OBJECT->value,
            self::FLOAT->value,
            self::INT->value,
            self::STDCLASS->value => true,
            default => false
        };
    }
}
