<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class EmailExists extends Constraint
{
    public $message = 'Введенный email {{ email }} уже используется учеником: {{ fio }}';
    public $currentObject;
}