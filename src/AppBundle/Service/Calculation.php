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
    private $correctAnswers;
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
        //массив объектов вопросов по id
        foreach ($test->getQuestions() as $question) {
            $questions[$question->getId()] = $question;
        }

        //перебираем вопросы с присвоением ответов ученика в answers
        foreach ($testArray['questions'] as $key => $this->answers) {

            //объект проверяемого вопроса
            /** @var Question question */
            $this->question = $questions[$key];

            //правильные ответы проверяемого вопроса
            /** @var Variant correctAnswers */
            $this->correctAnswers = $this->em->getRepository(Variant::class)
                ->findBy(['question' => $key, 'is_correct' => 1]);

            //вызываем функцию по типу вопроса
            $functionName = 'type' . ucfirst($this->question->getType());
            $this->$functionName();
        }

        return $this->mark;
    }

    private function typeRadiobutton()
    {
        ($this->answers == $this->correctAnswers[0]->getId()) ? ($this->mark += $this->percent) : $this->mark;
    }

    private function typeCheckbox()
    {
        //если количество ответов равно количеству вариантов
        // - рассматриваем этот ответ как не правильный
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