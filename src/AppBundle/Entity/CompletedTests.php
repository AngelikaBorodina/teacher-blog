<?php
/**
 * Created by PhpStorm.
 * User: angelika
 * Date: 30.01.19
 * Time: 23:21
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="completed_tests")
 * Class CompletedTests
 * @package AppBundle\Entity
 */
class CompletedTests
{
    /**
     * @ORM\Id //первичный ключ
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO") //автоинкремент
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User",inversedBy="tests")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="cascade", nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Test")
     * @ORM\JoinColumn(name="test_id", referencedColumnName="id", onDelete="cascade", nullable=false)
     */
    private $test;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $answers;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $mark;

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
     * Set answers
     *
     * @param string $answers
     *
     * @return CompletedTests
     */
    public function setAnswers($answers)
    {
        $this->answers = $answers;

        return $this;
    }

    /**
     * Get answers
     *
     * @return string
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * Set mark
     *
     * @param integer $mark
     *
     * @return CompletedTests
     */
    public function setMark($mark)
    {
        $this->mark = $mark;

        return $this;
    }

    /**
     * Get mark
     *
     * @return integer
     */
    public function getMark()
    {
        return $this->mark;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return CompletedTests
     */
    public function setUser(\AppBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set test
     *
     * @param \AppBundle\Entity\Test $test
     *
     * @return CompletedTests
     */
    public function setTest(\AppBundle\Entity\Test $test)
    {
        $this->test = $test;

        return $this;
    }

    /**
     * Get test
     *
     * @return \AppBundle\Entity\Test
     */
    public function getTest()
    {
        return $this->test;
    }
}
