<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Classes;
use AppBundle\Validator\Constraints\EmailExists;
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
            ->add('fio', null, ['label' => 'Фамилия Имя Отчество'])
            ->add('class', null, ['label' => 'Класс'])
            ->add('email', null, ['label' => 'E-mail'])
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('fio', null, ['label' => 'Фамилия Имя Отчество'])
            ->add('class', null, ['label' => 'Класс'])
            ->add('email', null, ['label' => 'E-mail'])
            ->add('password', null, ['label' => 'Пароль'])
            ->add('_action', null, [
                'actions' => [
                    'edit' => [],
                    'delete' => [],
                ],
                'label' => 'Действия'
            ])
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('fio', TextType::class, [
                'label' =>  'Фамилия Имя Отчество',
                'required'  =>  true,
                'constraints'   =>  [
                    new NotBlank(['message' => 'Заполни ФИО']),
                    new Regex(['pattern' => '/[а-яА-ЯёЁ]/', 'message' => 'Неверно заполнено ФИО']),
                    new Length(['min' => 10, 'minMessage' => 'Слишком короткое ФИО'])
                ]
            ])
            ->add('email', null, [
                'label' =>  'E-mail',
                'constraints'   =>  [
                    new NotBlank(['message' => 'Заполни E-mail']),
                    new Email(['message' => 'Неверно заполнен E-mail']),
                    new EmailExists()
                ]
            ])
            ->add('password', null, [
                'label' =>  'Пароль',
                'constraints'   =>  [
                    new NotBlank(['message' => 'Заполни пароль'])
                ]
            ])
            ->add('class', EntityType::class, [
                'class' =>  Classes::class,
                'label' =>  'Класс',
                'constraints'   =>  [
                    new NotBlank(['message' => 'Заполни пароль'])
                ]
            ])
        ;
    }
}
