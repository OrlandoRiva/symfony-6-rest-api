<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class NameValidation extends Constraint
{
    public $message = 'The string "{{ value }}" must contain either the text "Face" (case sensitive) or the text "Tec" (case insensitive).';
}