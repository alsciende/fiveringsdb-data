<?php

namespace App\Validator\Constraints;

use App\Model\Card;
use Cocur\Slugify\SlugifyInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 */
class HasCorrectSlugValidator extends ConstraintValidator
{
    /**
     * @param Card $value
     * @param HasCorrectSlug $constraint
     * @return void
     */
    #[\Override]
    public function validate($value, Constraint $constraint): void
    {
        $slugger = new AsciiSlugger();

        if ($value instanceof Card && $constraint instanceof HasCorrectSlug) {
            if ($slugger->slug($value->getFullName())->toString() !== $value->getId()) {
                $this->context->buildViolation($constraint->message)
                              ->setParameter('{{ card.name }}', $value->getName())
                              ->addViolation();
            }
        }
    }
}
