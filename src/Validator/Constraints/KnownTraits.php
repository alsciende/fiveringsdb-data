<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class KnownTraits extends Constraint
{
    public $message = 'The trait "{{ trait }}" is unknown.';

    public function getTargets ()
    {
        return self::PROPERTY_CONSTRAINT;
    }
}