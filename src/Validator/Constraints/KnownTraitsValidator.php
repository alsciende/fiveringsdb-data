<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class KnownTraitsValidator extends ConstraintValidator
{
    /**
     * @var array
     */
    private $traits = [];

    public function __construct()
    {
        $path = __DIR__ . '/../../../json/Label/en.json';
        $labels = json_decode(file_get_contents($path), true);
        foreach ($labels as $label) {
            if (strpos($label['id'], 'trait.') === 0) {
                $this->traits[substr($label['id'], 6)] = $label['value'];
            }
        }
    }

    public function validate($traits, Constraint $constraint)
    {
        foreach ($traits as $trait) {
            if (empty($this->traits[$trait])) {
                $this->context->buildViolation($constraint->message)
                              ->setParameter('{{ trait }}', $trait)
                              ->addViolation();
            }
        }
    }
}
