<?php
/**
 * Created by PhpStorm.
 * User: angelika
 * Date: 29.01.19
 * Time: 13:16
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Classes;
use AppBundle\Entity\CompletedTests;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Question;
use AppBundle\Entity\Variant;
use AppBundle\Entity\Test;

class ELTestController extends Controller
{
    const RADIO = 1;
    const CHECK = 2;
    const TEXT = 3;

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
            $variantsData=array();
            /** @var Variant $variant */
            foreach ($question->getVariants() as $variant) {
                $variant_id=$variant->getId();
                $variantsData[$variant_id]['variant'] = $variant->getDescription();
            }
            $question_id=$question->getId();
            $questionsData[$question_id]['question'] = $question->getDescription();
            $questionsData[$question_id]['image']    = $question->getImage();
            $questionsData[$question_id]['type']     = $question->getType();
            $questionsData[$question_id]['variants']  = $variantsData;
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
        $testArray = [
            'test'  =>  1,
            'user'  =>  1,
            'questions' =>  [
                1   =>  2,
                2   =>  [3, 6],
                3   =>  'зеленый'
            ]
        ];

        //return $this->json($testArray);
        //=======================================

        //$data=$request->query->all();

        /** @var Test $test */
        $test = $this->getDoctrine()->getRepository('AppBundle:Test')->find($testArray['test']);
        $procent = 100 / $test->getQuestions()->count();
        $mark=0;
        $questions = [];
        foreach ($test->getQuestions() as $question) {
            $questions[$question->getId()] = $question;
        }
        foreach ($testArray['questions'] as $key =>$answers){
            /** @var Question $question */
            $question = $questions[$key];

            /** @var Variant $correctAnswers */
            $correctAnswers = $this ->getDoctrine()->getRepository(Variant::class)
                        ->findBy(['question' => $key,'is_correct' => 1]);

            switch ($question->getType()) {
                case Test::RADIO:
                    ($answers == $correctAnswers[0]->getId()) ? ($mark += $procent) : $mark;
                    break;

                case Test::CHECK:
                    if (count($question->getVariants()) == count($answers)) {
                        break;
                    };
                    $procentItem = $procent / count($correctAnswers);

                    //перебираем массив правильных ответов
                    foreach ($correctAnswers as $value){
                        (in_array($value->getId(), $answers)) ? ($mark += $procentItem) : $mark;
                    }
                    break;

                case Test::TEXT:
                    ($answers == $correctAnswers[0]->getDescription()) ? ($mark += $procent) : $mark;
                    break;
            };
        }

        $completed = new CompletedTests();
        $completed
            ->setUser(
                $this->getDoctrine()->getRepository('AppBundle:User')->find($testArray['user']))
            ->setTest($test)
            ->setMark($mark)
            ->setAnswers(json_encode($testArray['questions']));
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($completed);
        $entityManager->flush();

        return new Response('');
    }
}