<?php
/**
 * Created by PhpStorm.
 * User: angelika
 * Date: 29.01.19
 * Time: 16:34
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * Class User
 * @package AppBundle\Entity
 */
class User
{
    /**
     * @ORM\Id //первичный ключ
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO") //автоинкремент
     */
    private $id;

    /**
     * @ORM\Column(type="string",length=255, nullable=false)
     */
    private $fio;

    /**
     * @ORM\ManyToOne(targetEntity="Classes")
     * @ORM\JoinColumn(name="class_id", referencedColumnName="id")
     */
    private $class;

    /**
     * @ORM\Column(type="string",length=255, nullable=false)
     */
    private $email;

    /**
     * @ORM\Column(type="string",length=255, nullable=false)
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $admin=false;

    /**
     * @ORM\Column(type="object",length=255, nullable=true)
     */
    private $data;

    /**
     * @ORM\OneToMany(targetEntity="CompletedTests",mappedBy="user")
     */
    private $tests;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tests = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set fio
     *
     * @param string $fio
     *
     * @return User
     */
    public function setFio($fio)
    {
        $this->fio = $fio;

        return $this;
    }

    /**
     * Get fio
     *
     * @return string
     */
    public function getFio()
    {
        return $this->fio;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set admin
     *
     * @param boolean $admin
     *
     * @return User
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;

        return $this;
    }

    /**
     * Get admin
     *
     * @return boolean
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * Set data
     *
     * @param string $data
     *
     * @return User
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set class
     *
     * @param \AppBundle\Entity\Classes $class
     *
     * @return User
     */
    public function setClass(\AppBundle\Entity\Classes $class = null)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Get class
     *
     * @return \AppBundle\Entity\Classes
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Add test
     *
     * @param \AppBundle\Entity\CompletedTests $test
     *
     * @return User
     */
    public function addTest(\AppBundle\Entity\CompletedTests $test)
    {
        $this->tests[] = $test;

        return $this;
    }

    /**
     * Remove test
     *
     * @param \AppBundle\Entity\CompletedTests $test
     */
    public function removeTest(\AppBundle\Entity\CompletedTests $test)
    {
        $this->tests->removeElement($test);
    }

    /**
     * Get tests
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTests()
    {
        return $this->tests;
    }
}
