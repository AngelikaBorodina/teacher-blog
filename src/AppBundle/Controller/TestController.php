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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\ClickableInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Question;
use AppBundle\Entity\Answer;
use AppBundle\Entity\Test;

class TestController extends Controller
{
    /**
     * @param Request $request
     * @param $id
     * @Route("/test/{id}", name="test", requirements={"id": "[0-9]+"})
     * @return string
     */
    public function indexAction (Request $request, $id) {

        $questionsData=Array();

        /** @var Test $test */
        $test=$this->getDoctrine()->getRepository('AppBundle:Test')->find($id);

        $testData=Array();
        $testData['title']=$test->getTitle();

        /** @var Question $question */
        foreach ($test->getQuestions() as $question) {
            $answersData=array();
            /** @var Answer $answer */
            foreach ($question->getAnswers() as $answer) {
                $answer_id=$answer->getId();
                $answersData[$answer_id]['answer']      = $answer->getAnswer();
                $answersData[$answer_id]['is_correct']  = $answer->getIsCorrect();
            }
            $question_id=$question->getId();
            $questionsData[$question_id]['question'] = $question->getQuestion();
            $questionsData[$question_id]['image']    = $question->getImage();
            $questionsData[$question_id]['type']     = $question->getType()->getName();
            $questionsData[$question_id]['answers']  = $answersData;
        }
        $testData['questions']=$questionsData;

        return $this->json($testData);
//        return $this->render('default/test.html.twig', [
//            'Collection'    =>  $testData
//        ]);
    }

    /**
     * @param Request $request
     * @Route("/create", name ="create")
     */
    public function formAction(Request $request)
    {
        $test=new Test();
//        dump($test);die();
        $form=$this->createFormBuilder($test)
            ->add('title',TextType::class, ['label'=>'Введите название теста'])
            ->add('save',SubmitType::class,['label'=>'Создать'])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $test=$form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($test);
            $entityManager->flush();
            return $this->redirectToRoute('create');
        }
        return $this->render('default/test.html.twig',['form'=>$form->createView()]);
    }

    /**
     * @param Request $request
     * @Route("/createForm", name ="createForm")
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