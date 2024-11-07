<?php

namespace App\Model;

enum Type: string
{
    case ATTACHMENT = 'attachment';
    case CHARACTER = 'character';
    case EVENT = 'event';
    case HOLDING = 'holding';
    case PROVINCE = 'province';
    case ROLE = 'role';
    case STRONGHOLD = 'stronghold';

    /**
     * @return array<string>
     */
    public static function values(): array
    {
        return array_map(fn (self $case) => $case->value, self::cases());
    }
}