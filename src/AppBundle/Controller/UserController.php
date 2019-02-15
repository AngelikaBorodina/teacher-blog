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
use AppBundle\Validator\Constraints\EmailExists;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class UserController extends Controller
{

    /**
     * @param Request $request
     * @Route("/reg", name="reg")
     * @return Response
     */
    public function actionRegister(Request $request)
    {
        // массив введеных данных пользователем
//        $input = [
//            'name'  => $request->get('name'),
//            'email' => $request->get('email'),
//            'class' => $request->get('class'),
//            'password' => $request->get('password')
//        ];

        $input = [
            'fio'  => 'Мухина Светлана Викторовна',
            'email' => '1@mail.ru',
            'id_class' => '2',
            'password' => '000000',
            'verifyPassword' => '000000'
        ];

        // массив проверок для данных
        $constraints = [
            'fio'  =>  [
                new NotBlank(['message' => 'Имя не должно быть пустым']),
//                new Regex(['pattern' => '/^[а-яА-ЯёЁ ]+$/', 'message' => 'Недопустимые символы в строке']),
                new Length(['min' => 10, 'minMessage' => 'Слишком короткое ФИО'])
            ],
            'email' =>  [
                new NotBlank(['message' => 'Email не должен быть пустым']),
                new Email(['message' => 'Неверный формат']),
                new EmailExists(['message' => 'Данный email уже используется'])
            ],
            'id_class' =>  [
                new NotBlank(['message' => 'Выберите номер своего класса'])
            ],
            'password' =>  [
                new NotBlank(['message' => 'Введите пароль']),
                new Length(['min' => 6, 'minMessage' => 'Минимальное количество символов: 6']),
                new Regex(['pattern' => '/^([a-zA-Z0-9\_])+$/', 'message' => 'Допустимые символы: латинские буквы, цифры и _'])
            ],
            'verifyPassword' => [
                new Regex(['pattern' => '/^' . $input['password'] . '$/', 'message' => 'Пароли не совпадают'])
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
//            return $this->json($errors);
            dump($errors);die;
        }

        //сохраяняем в базу
        $user=new User();
        $user->setFio($input['fio'])
            ->setEmail($input['email'])
            ->setPassword(md5($input['password']))
            ->setClass(
                $this->getDoctrine()->getRepository(Classes::class)
                    ->find($input['id_class']));
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return new Response('');
    }

    /**
     * @Route("/auth", name="reg")
     * @param Request $request
     * @return Response
     */
    public function actionAuth(Request $request)
    {
        $input = [
            'email'     => '1@mail.ru',
            'password'  => '000000'
        ];

        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $input['email']]);
        if (!isset($user)) {
            return $this->json(['error' => 'Введен неправильный email']);
        }

        if (!($user->getPassword() === md5($input['password']))) {
            return $this->json(['error' => 'Введен неправильный пароль']);
        }

        if (!$user->getActive()) {
            return $this->json(['error' => 'Ваша учетка не подтверждена, обратитесь к администратору сайта']);
        }

        $data = [
            'id'    =>  $user->getId(),
            'fio'   =>  $user->getFio(),
            'class' =>  $user->getClass()->getClass()
        ];

//        return $this->json($data);
        dump($user);die;
        return new Response('');
    }

}