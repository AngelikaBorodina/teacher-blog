<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Test;
use AppBundle\Form\Admin\DataTransformer;
use AppBundle\Form\Admin\QuestionType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class TestAdmin extends AbstractAdmin
{
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title', null, [
                'label' =>  'Название теста'
            ])
            ->add('active', null, [
                'label' =>  'Активный'
            ])
            ->add('_action', null, [
                'label' =>  'Действия',
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
        /** @var Test $test */
        $test = $this->getSubject();
        $container = $this->getConfigurationPool()->getContainer();
        $transformer = new DataTransformer($container->get('doctrine.orm.default_entity_manager'), $test);

        $formMapper
            ->add('title', null, ['label' => 'Название теста'])
            ->add('active', null, ['label' => 'Активный'])
            ->add('questions', CollectionType::class, [
                'required' => false,
                'label' =>  'Вопросы:',
                'entry_type'    =>  QuestionType::class,
                'allow_add' =>  true,
                'allow_delete'  =>  true,
            ])
            ->get('questions')->addModelTransformer($transformer);

    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('title', null, ['label' => 'Название теста'])
            ->add('active', null, ['label' => 'Активный'])
        ;
    }
}
