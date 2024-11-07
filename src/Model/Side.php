<?php

namespace App\Model;

enum Side: string
{
    case CONFLICT = 'conflict';
    case DYNASTY = 'dynasty';
    case PROVINCE = 'province';
    case ROLE = 'role';

    /**
     * @return array<string>
     */
    public static function values(): array
    {
        return array_map(fn (self $case) => $case->value, self::cases());
    }
}