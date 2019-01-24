<?php
/**
 * Created by PhpStorm.
 * User: angelika
 * Date: 23.01.19
 * Time: 15:22
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
//        $this->getDoctrine()->getManager();
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

}