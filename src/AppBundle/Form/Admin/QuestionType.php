<?php
/**
 * Created by PhpStorm.
 * User: angelika
 * Date: 24.01.19
 * Time: 17:08
 */

namespace AppBundle\Form\Admin;

use AppBundle\Entity\Question;
use AppBundle\Form\Admin\Type\AnswerType;
use Doctrine\DBAL\Types\TextType;
use Sonata\Form\Type\CollectionType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id',HiddenType::class)
            ->add('description',TextareaType::class, [
                'required' => false,
                'label' => 'Текст вопроса'
            ])
            ->add('image',FileType::class, [
                'required' => false,
                'label' => 'Загрузить картинку'
            ])
            ->add('type',ChoiceType::class, [
                'label' => 'Тип ответов',
                'choices'  => [
                    'Один из списка' => Question::RADIO,
                    'Несколько из списка' => Question::CHECK,
                    'Свободный ответ' => Question::TEXT
                ],
                'attr'  =>  ['style' => 'border-bottom: 3px solid blue']
            ])
        ;
    }
}