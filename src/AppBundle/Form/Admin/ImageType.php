<?php
/**
 * Created by PhpStorm.
 * User: angelika
 * Date: 10.02.19
 * Time: 16:07
 */

namespace AppBundle\Form\Admin;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'path' => ''
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['pathImg'] = 'uploads/'.$options['path'];
    }

    public function getParent()
    {
        return FileType::class;
    }

}