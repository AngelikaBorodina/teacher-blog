<?php
/**
 * Created by PhpStorm.
 * User: angelika
 * Date: 15.02.19
 * Time: 19:54
 */

namespace AppBundle\Service;


use AppBundle\Entity\Classes;
use AppBundle\Entity\Question;
use AppBundle\Entity\Test;
use AppBundle\Entity\Variant;
use Doctrine\ORM\EntityManagerInterface;

class ParserTest
{
    private $em;

    function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function loadTest($file)
    {
        $typeQuestion = [
            '1' => Question::RADIO,
            '2' => Question::CHECK,
            '3' => Question::TEXT
        ];

        $f = fopen($file, "r") or die("Ошибка!");
        $test = New Test();
        $test
            ->setClass($this->em->getRepository(Classes::class)->find('2'))
            ->setTitle('Через парсер');
        $question = '';
        while (($string = fgets($f)) !== false) {
            $data = explode(';', $string );
            if ($data[0]){
                if ($question instanceof Question){
                    $test->addQuestion($question);
                }
                $question = new Question();
                $question
                    ->setType($typeQuestion[$data[0]])
                    ->setDescription($data[1])
                    ->setTest($test);
            } else {
                if (!$question instanceof Question) {
                    throw new \Exception('Ошибка парсера');
                }
                $variant = new Variant();
                $variant
                    ->setDescription($data[1])
                    ->setIsCorrect(/*boolval(*/(bool)$data[2]/*)*/)
                    ->setQuestion($question);
                dump($data[2]);
                $question->addVariant($variant);
            }
        }
        if ($question instanceof Question){
            $test->addQuestion($question);
        }
//        $this->em->persist($test);
//        $this->em->flush();
        dump($test);die;
    }

}