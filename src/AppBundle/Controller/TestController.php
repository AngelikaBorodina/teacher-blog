<?php
/**
 * Created by PhpStorm.
 * User: angelika
 * Date: 23.01.19
 * Time: 15:22
 */

namespace AppBundle\Controller;

use AppBundle\Form\QuestionType;
use AppBundle\Form\TestType;
use AppBundle\Service\Messenger;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Question;
use AppBundle\Entity\Variant;
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

        return $this->render('default/test.html.twig',[
            'form'=>$formTest->createView(),
            'formQuestion'=>$formQuestion
        ]);
    }
}