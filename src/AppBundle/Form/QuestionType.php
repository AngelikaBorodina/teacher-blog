<?php
/**
 * Created by PhpStorm.
 * User: angelika
 * Date: 24.01.19
 * Time: 17:08
 */

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
//use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('question',TextareaType::class,['label'=>'Текст вопроса'])
            ->add('image',FileType::class,['label' => 'Загрузить картинку'])
            ->add('type',EntityType::class, [
                'class' => 'AppBundle:Type',
                'choice_label' => 'name',
                'label' => 'Тип вопроса'])
            ->add('save',SubmitType::class,['label'=>'сохранить']);
    }
//    public function configureOptions(OptionsResolver $resolver)
//    {
//        $resolver->setDefaults(['data_class'=>null,]);
//    }
}