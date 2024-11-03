<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class KnownTraitsValidator extends ConstraintValidator
{
    /** @var string[] */
    private array $traits = [];

    public function __construct()
    {
        $path = __DIR__ . '/../../../json/Label/en.json';
        $labels = json_decode(file_get_contents($path), true);
        foreach ($labels as $label) {
            if (str_starts_with((string) $label['id'], 'trait.')) {
                $this->traits[substr((string) $label['id'], 6)] = $label['value'];
            }
        }
    }

    /**
     * @param string[] $value
     * @param KnownTraits $constraint
     * @return void
     */
    #[\Override]
    public function validate($value, Constraint $constraint): void
    {
        foreach ($value as $trait) {
            if (empty($this->traits[$trait])) {
                $this->context->buildViolation($constraint->message)
                              ->setParameter('{{ trait }}', $trait)
                              ->addViolation();
            }
        }
    }
}
