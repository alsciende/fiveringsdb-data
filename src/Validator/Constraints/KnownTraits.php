<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class KnownTraits extends Constraint
{
    public string $message = 'The trait "{{ trait }}" is unknown.';

    #[\Override]
    public function getTargets(): array|string
    {
        return self::PROPERTY_CONSTRAINT;
    }
}