<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class ClassExists extends Constraint
{
    public $message="Такой класс уже существует";

}