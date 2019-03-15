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
use AppBundle\Service\Calculation;
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

    /**
     * @param $id
     * @Route("/test/{id}", name="test", requirements={"id": "[0-9]+"})
     * @return string
     */
    public function indexAction($id){

        $questionsData = Array();

        /** @var Test $test */
        $test = $this->getDoctrine()->getRepository('AppBundle:Test')->find($id);

        $testData = Array();
        $testData['title'] = $test->getTitle();

        /** @var Question $question */
        foreach ($test->getQuestions() as $question) {
            $variantsData = array();
            /** @var Variant $variant */
            foreach ($question->getVariants() as $variant) {
                $variant_id = $variant->getId();
                $variantsData[$variant_id]['variant'] = $variant->getDescription();
            }
            $question_id = $question->getId();
            $questionsData[$question_id]['question'] = $question->getDescription();
            $questionsData[$question_id]['image']    = $question->getImage();
            $questionsData[$question_id]['type']     = $question->getType();
            $questionsData[$question_id]['variants'] = $variantsData;
        }
        $testData['questions'] = $questionsData;
        return $this->json($testData);
    }

    /**
     * @param Request $request, Calculation $calculation
     * @Route("/checkTest", name="checkTest")
     * @return Response
     */
    public function CheckTestAction(Request $request, Calculation $calculation)
    {
        $testArray = [
            'test'  =>  11,
            'user'  =>  1,
            'questions' =>  [
                30   =>  31,
                32   =>  [35, 37],
                31   =>  'зеленый'
            ]
        ];
        //=======================================

        //$data=$request->query->all();
        /** @var Test $test */
        $test = $this->getDoctrine()->getRepository('AppBundle:Test')->find($testArray['test']);
        $mark=$calculation->calcMain($testArray,$test);
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