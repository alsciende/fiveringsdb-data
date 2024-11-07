<?php

namespace App\Model;

enum Element: string
{
    case AIR = 'air';
    case EARTH = 'earth';
    case FIRE = 'fire';
    case VOID = 'void';
    case WATER = 'water';

    /**
     * @return array<string>
     */
    public static function values(): array
    {
        return array_map(fn (self $case) => $case->value, self::cases());
    }
}