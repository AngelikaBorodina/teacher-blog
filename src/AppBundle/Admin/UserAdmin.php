<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Classes;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class UserAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('fio')
            ->add('email')
            ->add('password')
            ->add('admin')
            ->add('date')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('fio')
            ->add('email')
            ->add('password')
            ->add('admin')
            ->add('date')
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ])
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('fio', TextType::class, [
                'label' =>  'ФИО',
                'required'  =>  true,
                'constraints'   =>  [
                    new NotBlank(['message' => 'Заполни ФИО']),
                    new Regex(['pattern' => '/^\d+$/', 'message' => 'Неверно заполнено ФИО']),
                    new Length(['min' => 5, 'minMessage' => 'min', 'max' => 10, 'maxMessage' => 'max'])
                ]
            ])
            ->add('email', EmailType::class, [
                'constraints'   =>  [
                    new Email(['message' => 'Неверно заполнен E-mail'])
                ]
            ])
            ->add('password')
            ->add('admin')
            ->add('date')
            ->add('class', EntityType::class, [
                'class' =>  Classes::class
            ])
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('fio')
            ->add('email')
            ->add('password')
            ->add('admin')
            ->add('date')
        ;
    }
}
