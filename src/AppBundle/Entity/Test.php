<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="test")
 * Class Test
 * @package AppBundle\Entity
 */
class Test
{
    /**
     * @ORM\Id //первичный ключ
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO") //автоинкремент
     */
    private $id;

    /**
     * @ORM\Column(name="title",type="string",length=255,nullable=true)
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity="Question", mappedBy="test")
     *
     */
    private $questions;

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
     * Set title
     *
     * @param string $title
     *
     * @return Test
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->questions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add question
     *
     * @param \AppBundle\Entity\Answer $question
     *
     * @return Test
     */
    public function addQuestion(\AppBundle\Entity\Answer $question)
    {
        $this->questions[] = $question;

        return $this;
    }

    /**
     * Remove question
     *
     * @param \AppBundle\Entity\Answer $question
     */
    public function removeQuestion(\AppBundle\Entity\Answer $question)
    {
        $this->questions->removeElement($question);
    }

    /**
     * Get questions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestions()
    {
        return $this->questions;
    }
}
