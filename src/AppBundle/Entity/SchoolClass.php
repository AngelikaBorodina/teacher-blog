<?php
/**
 * Created by PhpStorm.
 * User: angelika
 * Date: 29.01.19
 * Time: 16:40
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="school_class")
 * Class SchoolClass
 * @package AppBundle\Entity
 */
class SchoolClass
{
    /**
     * @ORM\Id //первичный ключ
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO") //автоинкремент
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $class;

    /**
     * @ORM\OneToMany(targetEntity="Student", mappedBy="$class")
     */
    private $students;
}