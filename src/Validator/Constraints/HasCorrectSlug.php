<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class HasCorrectSlug extends Constraint
{
    public $message = 'The card "{{ card.name }}" has an incorrect slug id.';

    public function getTargets ()
    {
        return self::CLASS_CONSTRAINT;
    }
}
