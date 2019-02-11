<?php

namespace AppBundle\Admin;

use AppBundle\Form\Admin\ImageType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ProgressAdmin extends AbstractAdmin
{
    private $dir = 'progress';

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('file', ImageType::class, [
                'label'=>'Фото'
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
                'path'  => $this->dir.'/'.$progress->getPathImage()
            ])
        ;
    }

//    protected function configureShowFields(ShowMapper $showMapper)
//    {
//        $showMapper
//            ->add('id')
//            ->add('pathImage')
//        ;
//    }
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

        if (file_exists($fileUploader->getTargetDirectory() . $this->dir . '/' . $image->getPathImage())){
            $fileUploader->remove($image->getPathImage(), $this->dir);
        }

        $uploadImage = $image->getFile();
        $pathFile=$fileUploader->upload($uploadImage, $this->dir);
        $image->setPathImage($pathFile);
        $image->setFile(null);
    }

    public function preRemove($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $fileUploader = $container->get('app.service.file_uploader');
        $fileUploader->remove($object->getPathImage(), $this->dir);
    }
}
