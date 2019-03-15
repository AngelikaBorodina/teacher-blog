<?php
/**
 * Created by PhpStorm.
 * User: angelika
 * Date: 03.02.19
 * Time: 14:17
 */

namespace AppBundle\Validator\Constraints;


use AppBundle\Entity\Classes;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ClassExistsValidator extends ConstraintValidator
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em=$em;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ClassExists) {
            throw new UnexpectedTypeException($constraint, ClassExists::class);
        }

        $class=$this->em->getRepository(Classes::class)->findOneBy(['class'=>$value]);
        if (isset($class)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }

}