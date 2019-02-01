<?php
/**
 * Created by PhpStorm.
 * User: angelika
 * Date: 31.01.19
 * Time: 22:26
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Classes;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserController extends Controller
{

    /**
     * @param Request $request
     * @Route("/reg", name="reg")
     * @return Response
     */
    public function actionRegister(Request $request)
    {
        $input = [
            'name'  =>  $request->get('name'),
            'email' =>  $request->get('email')
        ];

        $constraints = [
            'name'  =>  [
                new NotBlank(['message' => 'empty name'])
            ],
            'email' =>  [
                new Email(['message' => 'empty email'])
            ]
        ];

        $validator = $this->get('validator');
        $errors = [];
        foreach ($input as $field => $value) {
            $validationResult = $validator->validate($value, $constraints[$field]);
            if (count($validationResult)) {
                $errors[$field] = $validationResult[0]->getMessage();
            }
        }
        if (count($errors) > 0) {

        }
        dump($errors);die;
        ///==============================
        //$date=$request->query->all();

        $date['fio']='Муркина Галина Викторовна';
        $date['email']='1@mail.ru';
        $date['password']='123';
        $date['class']='2';

        if (!$this->getDoctrine()->getRepository(User::class)
                ->findBy(['email'=>$date['email']])){
            $user=new User();
            $user->setFio($date['fio'])
                ->setEmail($date['email'])
                ->setPassword($date['password'])
                ->setClass(
                    $this->getDoctrine()->getRepository(Classes::class)
                        ->find($date['class']));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        }
        //dump($date['email']);die();
        return new Response('');
    }

}