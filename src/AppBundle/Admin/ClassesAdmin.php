<?php

namespace AppBundle\Admin;

use AppBundle\Validator\Constraints\ClassExists;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ClassesAdmin extends AbstractAdmin
{
//    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
//    {
//        $datagridMapper
//            ->add('class')
//        ;
//    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('class', null, ['label'=>'Класс'])
            ->add('_action', null, [
                'actions' => [
                    'edit' => [],
                    'delete' => [],
                ],
                'label'=>'Действия'
            ])
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('class', null, [
                'label'=>'Класс',
                'constraints'   =>  [
                    new NotBlank(['message' => 'Заполни класс']),
                    new Regex(['pattern' => '/^([1-9]{1}|10|11)$/', 'message' => 'Нет такого номера класса']),
                    new ClassExists()]
            ]);

    }

//    protected function configureShowFields(ShowMapper $showMapper)
//    {
//        $showMapper
//            ->add('id')
//            ->add('class')
//        ;
//    }
}
