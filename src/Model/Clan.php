<?php

namespace App\Model;

enum Clan: string
{
    case CRAB = 'crab';
    case CRANE = 'crane';
    case DRAGON = 'dragon';
    case LION = 'lion';
    case NEUTRAL = 'neutral';
    case PHOENIX = 'phoenix';
    case SCORPION = 'scorpion';
    case UNICORN = 'unicorn';

    /**
     * @return array<string>
     */
    public static function values(): array
    {
        return array_map(fn (self $case) => $case->value, self::cases());
    }
}