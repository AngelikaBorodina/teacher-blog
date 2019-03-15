<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Classes;
use AppBundle\Validator\Constraints\EmailExists;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\DoctrineORMAdminBundle\Filter\BooleanFilter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

final class UserAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'students';
    protected $baseRouteName = 'admin_students';

    public function createQuery($context = 'list')
    {
        /** @var QueryBuilder $query */
        $query = parent::createQuery($context);
        $query
            ->andWhere('o.admin = :admin')
            ->setParameter('admin', false);

        return $query;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('fio', null, ['label' => 'Фамилия Имя Отчество'])
            ->add('class', null, ['label' => 'Класс'])
            ->add('email', null, ['label' => 'E-mail'])
            ->add('active', null, ['label' => 'Активный'])
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('fio', null, ['label' => 'Фамилия Имя Отчество'])
            ->add('class', null, ['label' => 'Класс'])
            ->add('email', null, ['label' => 'E-mail'])
            ->add('password', null, ['label' => 'Пароль'])
            ->add('active', null, ['label' => 'Активный'])
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
                    new NotBlank(['message' => 'Поле "ФИО" не должно быть пустым']),
                    new Regex(['pattern' => '/^[а-яА-ЯёЁ ]+$/', 'message' => 'Неверно заполнено ФИО']),
                    new Length(['min' => 10, 'minMessage' => 'Слишком короткое ФИО'])
                ]
            ])
            ->add('active', null, ['label' => 'Активный'])
            ->add('email', null, [
                'label' =>  'E-mail',
                'constraints'   =>  [
                    new NotBlank(['message' => 'Поле "E-mail" не должно быть пустым']),
                    new Email(['message' => 'Неверно заполнен E-mail']),
                    new EmailExists(['currentObject' => $this->getSubject()])
                ]
            ])
            ->add('password', null, [
                'label' =>  'Пароль',
                'constraints'   =>  [
                    new NotBlank(['message' => 'Необходимо создать пароль'])
                ]
            ])
            ->add('class', EntityType::class, [
                'class' =>  Classes::class,
                'label' =>  'Класс',
                'constraints'   =>  [
                    new NotBlank(['message' => 'Поле "Класс" не должно быть пустым'])
                ]
            ])
        ;
    }
}
