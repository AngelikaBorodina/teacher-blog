<?php
/**
 * Created by PhpStorm.
 * User: angelika
 * Date: 03.02.19
 * Time: 20:28
 */

namespace AppBundle\Form\Admin;


use AppBundle\Entity\Question;
use AppBundle\Entity\Test;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\DataTransformerInterface;

class DataTransformer implements DataTransformerInterface
{
    private $em;
    private $test;
    function __construct(EntityManager $entityManager, Test $test)
    {
        $this->em = $entityManager;
        $this->test = $test;
    }

    //при редактировании объекта. из объекта в строку
    public function transform($questions)
    {
        $collection = $this->test->getQuestions();
        $array = [];
        /** @var Question $value */
        foreach ($collection as $value) {
            $question['id'] = $value->getId();
            $question['description'] = $value->getDescription();
            $question['image'] = $value->getImage();
            $question['type'] = $value->getType();
            $array[] = $question;
        }
        return $array;
    }

    //при создании объекта. из строки в объекты
    public function reverseTransform($questions)
    {
        //Получаем МАССИВ объектов вопросов текущего теста
        //
        $dbCollection = $this->test->getQuestions()->toArray();

        $newCollection = new ArrayCollection();

        //Перебираем массив сохраненных вопросов
        //
        foreach ($questions as $question) {

            $objectQuestion = $this->em->getRepository(Question::class)
                            ->findOneBy(['id' => $question['id']]);

            //Если объект существует в базе -> обновляем его
            //Если это новый вопрос -> создаем новый объект
            //
            if (isset($objectQuestion)) {
                //оставляем в коллекции только те вопросы,которые нужно удалить из базы
                unset($dbCollection[array_search($objectQuestion, $dbCollection)]);
            } else {
                $objectQuestion = new Question();
            }

            $objectQuestion
                ->setTest($this->test)
                ->setDescription($question['description'])
                ->setImage($question['image'])
                ->setType($question['type']);

            $newCollection->add($objectQuestion);
        }

        //Удаляем из базы вопросы, удаленные пользователем
        foreach ($dbCollection as $value) {
            $this->em->remove($value);
            $this->em->flush();
        }

        return $newCollection;
    }
}