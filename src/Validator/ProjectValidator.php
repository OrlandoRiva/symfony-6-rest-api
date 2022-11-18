<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ProjectValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $message = "dasdasdas";
//        if (!$constraint instanceof FacetecString) {
//            throw new UnexpectedTypeException($constraint, FacetecString::class);
//        }

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) to take care of that
        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            // throw this exception if your validator cannot handle the passed type so that it can be marked as invalid
            throw new UnexpectedValueException($value, 'string');
        }

//        // Fail the validation if the string does not “Face” (case sensitive) or the text “Tec” (case insensitive)
//        if (!(preg_match("#Face#", $value) || preg_match("#tec#i", $value))) {
//            $this->context->buildViolation($constraint->message)
//                ->setParameter('{{ value }}', $value)
//                ->addViolation();
//        }
    }
}