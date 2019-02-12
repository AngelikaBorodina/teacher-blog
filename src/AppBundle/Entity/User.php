<?php
/**
 * Created by PhpStorm.
 * User: angelika
 * Date: 29.01.19
 * Time: 16:34
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

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
     * @ORM\Column(type="boolean")
     */
    private $active = false;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $photo;

    /** @var  File */
    private $file;


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
     * @param \stdClass $data
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
     * @return \stdClass
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return User
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return User
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
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

    /**
     * Set file
     *
     * @param File $file
     *
     * @return User
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }
}
