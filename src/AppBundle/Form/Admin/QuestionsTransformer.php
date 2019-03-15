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
use AppBundle\Service\FileUploader;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\DataTransformerInterface;

class QuestionsTransformer implements DataTransformerInterface
{
    private $em;
    private $test;
    private $fileUp;
    private $dir = 'questions';

    function __construct(EntityManager $entityManager, Test $test, FileUploader $fileUp)
    {
        $this->em = $entityManager;
        $this->test = $test;
        $this->fileUp = $fileUp;
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
            $pathFile='';
            $objectQuestion = $this->em->getRepository(Question::class)
                ->findOneBy(['id' => $question['id']]);

            //Если объект существует в базе -> обновляем его
            //Если это новый вопрос -> создаем новый объект
            //
            if (isset($objectQuestion)) {
                //оставляем в коллекции только те вопросы,которые нужно удалить из базы
                unset($dbCollection[array_search($objectQuestion, $dbCollection)]);

                //если в базе уже есть картинка, затираем её на сервере, так как название будет другое
                if ( $objectQuestion->getImage() && file_exists($this->fileUp->getTargetDirectory() . $this->dir . '/' . $objectQuestion->getImage())) {
                    $this->fileUp->remove($objectQuestion->getImage(), $this->dir);
                }

            } else {
                $objectQuestion = new Question();
            }

            //у объекта есть картинка?
            // да - загружаем в базу
            if (isset($question['file'])) {
                $pathFile = $this->fileUp->upload($question['file'], $this->dir);
            }

            $objectQuestion
                ->setTest($this->test)
                ->setDescription($question['description'])
                ->setImage($pathFile)
                ->setType($question['type'])
                ->setFile(null);

            $newCollection->add($objectQuestion);
        }
        //Удаляем из базы вопросы, удаленные пользователем
        //предварительно удалив картинку на сервере, если такая существует
        /** @var Question $value */
        foreach ($dbCollection as $value) {;
            if ($value->getImage() && file_exists($this->fileUp->getTargetDirectory() . $this->dir . '/' . $value->getImage())){
                $this->fileUp->remove($value->getImage(), $this->dir);
            }
            $this->em->remove($value);
            $this->em->flush();
        }

        return $newCollection;
    }
}