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
 * @ORM\Table(name="student")
 * Class Student
 * @package AppBundle\Entity
 */
class Student
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
    private $name;

    /**
     * @ORM\Column(type="string",length=255, nullable=false)
     */
    private $familyName;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $patronymic;//отчество

    /**
     * @ORM\ManyToOne(targetEntity="SchoolClass",inversedBy="students")
     * @ORM\JoinColumn(name="class_id", referencedColumnName="id", nullable=false)
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

}