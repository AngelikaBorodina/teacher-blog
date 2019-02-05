<?php

namespace AppBundle\Form\Admin\Type;

use Sonata\AdminBundle\Form\Type\Filter\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnswerType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
//        $resolver->setDefaults([
//            'test'  =>  null
//        ]);
//        $resolver->setDefaults([
//            'choices' => [
//                'Standard Question' => 'standard',
//                'Expedited Question' => 'expedited',
//                'Priority Question' => 'priority',
//            ],
//            'choices_as_values' => true,
//        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //parent::buildForm($builder, $options);
        /*$builder
            ->add('test', TextType::class, [
                'label' =>  'test'
            ]);*/
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        //parent::buildView($view, $form, $options);
//        $view->vars['test'] = 'test';
    }
}