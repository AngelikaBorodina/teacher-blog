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
 * @ORM\Table(name="classes")
 * Class Classes
 * @package AppBundle\Entity
 */
class Classes
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

    public function __toString()
    {
        return (string)$this->class;
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
     * Set class
     *
     * @param integer $class
     *
     * @return Classes
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Get class
     *
     * @return integer
     */
    public function getClass()
    {
        return $this->class;
    }
}
