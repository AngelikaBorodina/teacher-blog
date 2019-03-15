<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="variant")
 * Class Variant
 * @package AppBundle\Entity
 */
class Variant
{
    /**
     * @ORM\Id //первичный ключ
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO") //автоинкремент
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="variants")
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id", onDelete="cascade", nullable=false)
     */
    private $question;

    /**
     * @ORM\Column(type="string",length=255, nullable=false)
     */
    private $description;

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
     * Set description
     *
     * @param string $description
     *
     * @return Variant
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set isCorrect
     *
     * @param boolean $isCorrect
     *
     * @return Variant
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
     * @return Variant
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
