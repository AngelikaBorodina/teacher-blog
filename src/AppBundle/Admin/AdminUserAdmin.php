<?php

namespace AppBundle\Admin;

use AppBundle\Entity\User;
use AppBundle\Form\Admin\DataType;
use AppBundle\Form\Admin\ImageType;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

final class AdminUserAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'superadmin';
    protected $baseRouteName = 'super_admin';
    private $dir = 'avatar';

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
        $container = $this->getConfigurationPool()->getContainer();
        $em =$container->get('doctrine.orm.default_entity_manager');
        /** @var User $admin */
        $admin=$em->getRepository(User::class)->findOneBy(['admin' => true]);
        if($admin){
            $redirection = new RedirectResponse(
                $this->getConfigurationPool()
                    ->getContainer()->get('router')
                    ->generate('super_admin_show', ['id' => $admin->getId()]));
            $redirection->send();
        }
//        dump('Администратора не существует,его нужно заводить в базе данных');die;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $admin = $this->getSubject();
        $formMapper
            ->add('fio', TextType::class, [
                'label' =>  'ФИО',
                'required'  =>  true,
                'constraints'   =>  [
                    new NotBlank(['message' => 'Заполни ФИО']),
                    new Regex(['pattern' => '/[а-яА-ЯёЁ]/', 'message' => 'Неверно заполнено ФИО']),
                    new Length(['min' => 10, 'minMessage' => 'Слишком короткое ФИО'])]]
            )
            ->add('file', ImageType::class, [
                'required' => false,
                'label' => 'Фото',
                'path'  => $this->dir.'/'.$admin->getPhoto()
            ])
            ->add('data', 'sonata_type_native_collection', [
                'label' =>  'Характеристики:',
                'entry_type'    => DataType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('fio', null, [
                'label' => 'Фамилия Имя Отчество:'
            ])
            ->add('photo', null, [
                'label' => 'Фото',
                'template'  =>  '@App/Admin/superadmin/show/avatar.html.twig'

            ])
            ->add('data', null, [
                'label' => 'Данные:',
                'template'  =>  '@App/Admin/superadmin/show/data.html.twig'
            ])
        ;
    }

    public function configureActionButtons($action, $object = null)
    {
        $list['edit'] = [
            'template' => $this->getTemplate('button_edit'),
        ];

        return $list;
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
            if ($image->getPhoto()){
                $fileUploader->remove($image->getPhoto(), $this->dir);
            }
            $pathFile=$fileUploader->upload($uploadImage, $this->dir);
            $image->setPhoto($pathFile);
            $image->setFile(null);
        }
    }

    public function preRemove($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $fileUploader = $container->get('app.service.file_uploader');
        $fileUploader->remove($object->getPhoto(), $this->dir);
    }
}
