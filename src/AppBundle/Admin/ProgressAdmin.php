<?php

namespace AppBundle\Admin;

use AppBundle\Form\Admin\ImageType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ProgressAdmin extends AbstractAdmin
{
    private $dir = 'progress';

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('image', null, [
                'label' => 'Фото',
                'template'  =>  '@App/Admin/progress/list/image.html.twig'

            ])
            ->add('_action', null, [
                'actions' => [
                    'edit' => [],
                    'delete' => ['label' => 'удалить'],
                ],
                'label'=>'Действия'
            ])
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $progress = $this->getSubject();
        $formMapper
            ->add('file', ImageType::class, [
                'required' => false,
                'label' => 'Картинка',
                'path'  => $this->dir.'/'.$progress->getImage()
            ])
        ;
    }

    public function prePersist($image)
    {
        $this->uploadImage($image);
    }

    public function preUpdate($image)
    {
        $this->uploadImage($image);
    }

    public function uploadImage($image)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $fileUploader = $container->get('app.service.file_uploader');

        $uploadImage = $image->getFile();

        if ($uploadImage){
            if ($image->getImage()){
                $fileUploader->remove($image->getImage(), $this->dir);
            }
            $pathFile=$fileUploader->upload($uploadImage, $this->dir);
            $image->setImage($pathFile);
            $image->setFile(null);
        }
    }

    public function preRemove($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $fileUploader = $container->get('app.service.file_uploader');
        $fileUploader->remove($object->getImage(), $this->dir);
    }
}
