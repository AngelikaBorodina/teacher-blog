<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="answer")
 * Class Answer
 * @package AppBundle\Entity
 */
class Answer
{
    /**
     * @ORM\Id //первичный ключ
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO") //автоинкремент
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="answers")
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id", onDelete="cascade", nullable=false)
     */
    private $question;

    /**
     * @ORM\Column(type="string",length=255, nullable=false)
     */
    private $answer;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_correct=true;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set answer
     *
     * @param string $answer
     *
     * @return Answer
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set isCorrect
     *
     * @param boolean $isCorrect
     *
     * @return Answer
     */
    public function setIsCorrect($isCorrect)
    {
        $this->is_correct = $isCorrect;

        return $this;
    }

    /**
     * Get isCorrect
     *
     * @return boolean
     */
    public function getIsCorrect()
    {
        return $this->is_correct;
    }

    /**
     * Set question
     *
     * @param \AppBundle\Entity\Question $question
     *
     * @return Answer
     */
    public function setQuestion(\AppBundle\Entity\Question $question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return \AppBundle\Entity\Question
     */
    public function getQuestion()
    {
        return $this->question;
    }
}
