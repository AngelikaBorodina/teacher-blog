<?php
/**
 * Created by PhpStorm.
 * User: angelika
 * Date: 29.01.19
 * Time: 13:16
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Question;
use AppBundle\Entity\Answer;
use AppBundle\Entity\Test;

class ELTestController extends Controller
{
    /**
     * @param $id
     * @Route("/test/{id}", name="test", requirements={"id": "[0-9]+"})
     * @return string
     */
    public function indexAction($id){

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
                $answersData[$answer_id]['answer'] = $answer->getAnswer();
            }
            $question_id=$question->getId();
            $questionsData[$question_id]['question'] = $question->getQuestion();
            $questionsData[$question_id]['image']    = $question->getImage();
            $questionsData[$question_id]['type']     = $question->getType()->getName();
            $questionsData[$question_id]['answers']  = $answersData;
        }
        $testData['questions']=$questionsData;
        return $this->json($testData);
    }

    /**
     * @param Request $request
     * @Route("/checkTest", name="checkTest")
     * @return Response
     */
    public function CheckTestAction(Request $request)
    {
        $answer1=array();
        $answer1[1]['answer']=1;
        $answer1[1]['value']='';
        $answer1[2]['answer']=3;
        $answer1[2]['value']='';

        $answer2=array();
        $answer2[1]['answer']='';
        $answer2[1]['value']='6';

        $questions=array();
        $questions[1]['answers']=$answer1;
        $questions[2]['answers']='';
        $questions[3]['answers']=$answer2;

        $test=array();
        $test['test']=1;
        $test['user']=1;
        $test['questions']=$questions;
        //=======================================
        //$data=$request->query->all();
        foreach ($test as $key =>$item){

        }


        //dump();die();
        return new Response('');
    }
}