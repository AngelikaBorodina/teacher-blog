<?php
/**
 * Created by PhpStorm.
 * User: angelika
 * Date: 03.02.19
 * Time: 14:48
 */

namespace AppBundle\Validator\Constraints;


use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class EmailExistsValidator extends ConstraintValidator
{
    private $em;

    function __construct(EntityManagerInterface $em)
    {
        $this->em=$em;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof EmailExists) {
            throw new UnexpectedTypeException($constraint, EmailExists::class);
        }

        /** @var User $student */
        $student=$this->em->getRepository(User::class)->findOneBy(['email'=>$value]);
        if (isset($student)) {
            $this->context->buildViolation($constraint->massage)
                ->setParameters(['{{ email }}' => $value, '{{ fio }}' => $student->getFio()])
                ->addViolation();
        }
    }

}