<?php
/**
 * Created by PhpStorm.
 * User: angelika
 * Date: 23.01.19
 * Time: 15:22
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\QuestionType;
use AppBundle\Form\TestType;
use AppBundle\Service\Messenger;
use AppBundle\Service\ParserTest;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Question;
use AppBundle\Entity\CompletedTests;
use AppBundle\Entity\Test;

class TestController extends Controller
{
    /**
     * @Route("/createForm", name ="createForm")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function formClassAction(Request $request)
    {
        $test=new Test();
        $formTest=$this->createForm(TestType::class,$test);
        $formQuestion=false;

        $formTest->handleRequest($request);

        if ($formTest->isSubmitted() && $formTest->isValid()){

            if ($formTest->get('addQuestion')->isClicked()){
                $question=new Question();
                $formQuestion=$this->createForm(QuestionType::class,$question);

                $formQuestion->handleRequest($request);
                $formQuestion=$formQuestion->createView();
            }
            $test=$formTest->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($test);
            $entityManager->flush();
            //return $this->redirectToRoute('createForm');
        }

//        return $this->render('',[
//            'form'=>$formTest->createView(),
//            'formQuestion'=>$formQuestion
//        ]);
        return new Response('');
    }

    /**
     *  @Route("/parser", name ="parser")
     * @param Request $request
     * @param ParserTest $parser
     * @return Response
     */
    public function actionCheckParser(Request $request, ParserTest $parser) {

        $build = $this->createFormBuilder();
        $form = $build
            ->add('file', FileType::class)
            ->add('submit', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $parser->loadTest($form->getData()['file']);
        }
        return $this->render('@App/parser.html.twig', [
            'form' => $form->createView()
        ]);
//        return new Response('');
    }

    /**
     * @Route("/query_builder", name ="query_builder")
     * @return Response
     */
    public function actionQueryBuilder()
    {
        /** @var EntityRepository $userRepo */
        $userRepo = $this->getDoctrine()->getRepository('AppBundle:User');
        /** @var QueryBuilder $userQueryBuilder */
        $userQueryBuilder = $userRepo->createQueryBuilder('u');
        $result = $userQueryBuilder
            ->select(array('u.fio','sum(rez.mark) as mark'))
            ->leftJoin('AppBundle\Entity\CompletedTests', 'rez', 'WITH', 'rez.user = u.id')
            ->Where('u.class = ?1')
            ->groupBy('u.id')
            ->setParameter('1',1)
            ->getQuery()
            ->getResult();
        dump($result);die;

        return new Response('');
    }
}