<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Classes;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class AdminUserAdmin extends AbstractAdmin
{
    public function createQuery($context = 'list')
    {
        /** @var QueryBuilder $query */
        $query = parent::createQuery($context);
        $query
            ->andWhere('o.admin = :admin')
            ->setParameter('admin', true);

        return $query;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('date')
            ->add('_action', null, [
                'actions' => [
                    'edit' => []
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
        ;
    }
}
