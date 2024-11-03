<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class HasCorrectSlug extends Constraint
{
    public string $message = 'The card "{{ card.name }}" has an incorrect slug id.';

    #[\Override]
    public function getTargets(): array|string
    {
        return self::CLASS_CONSTRAINT;
    }
}
