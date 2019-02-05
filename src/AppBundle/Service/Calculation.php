<?php
/**
 * Created by PhpStorm.
 * User: angelika
 * Date: 01.02.19
 * Time: 14:03
 */

namespace AppBundle\Service;

use AppBundle\Entity\Question;
use AppBundle\Entity\Variant;
use AppBundle\Entity\Test;
use Doctrine\ORM\EntityManagerInterface;

class Calculation
{
    private $em;

    private $percent;
    private $mark=0;
    private $correctAnswers;//типизировать здесь можно?
    private $answers;
    private $question;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em=$em;
    }

    public function calcMain($testArray,Test $test)
    {
        $this->percent = 100 / $test->getQuestions()->count();
        $questions = [];
        foreach ($test->getQuestions() as $question) {
            $questions[$question->getId()] = $question;
        }
        foreach ($testArray['questions'] as $key => $this->answers) {

            /** @var Question question */
            $this->question = $questions[$key];

            /** @var Variant correctAnswers */
            $this->correctAnswers = $this->em->getRepository(Variant::class)
                ->findBy(['question' => $key, 'is_correct' => 1]);

            $functionName = 'type' . ucfirst($this->question->getType());
            $this->$functionName();
        }
        //dump($this->mark);die();
        return $this->mark;
    }

    private function typeRadiobutton()
    {
        ($this->answers == $this->correctAnswers[0]->getId()) ? ($this->mark += $this->percent) : $this->mark;
    }

    private function typeCheckbox()
    {
        if ($this->question->getVariants()->count() == count($this->answers)) {
                  return;
        };
        $percentItem = $this->percent / count($this->correctAnswers);

        //перебираем массив правильных ответов
        foreach ($this->correctAnswers as $value){
            (in_array($value->getId(), $this->answers)) ? ($this->mark += $percentItem) : $this->mark;
        }
    }

    private function typeText()
    {
        ($this->answers == $this->correctAnswers[0]->getDescription()) ? ($this->mark += $this->percent) : $this->mark;
    }

}