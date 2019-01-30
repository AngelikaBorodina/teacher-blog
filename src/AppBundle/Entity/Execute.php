<?php
/**
 * Created by PhpStorm.
 * User: angelika
 * Date: 29.01.19
 * Time: 16:12
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="execute")
 * Class Execute
 * @package AppBundle\Entity
 */
class Execute
{
    /**
     * @ORM\Id //первичный ключ
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO") //автоинкремент
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Student")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id", onDelete="cascade", nullable=false)
     */
    private $student;

    /**
     * @ORM\ManyToOne(targetEntity="Question")
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id", onDelete="cascade", nullable=false)
     */
    private $question;

    /**
     * @ORM\ManyToOne(targetEntity="Answer")
     * @ORM\JoinColumn(name="answer_id", referencedColumnName="id")
     */
    private $answer;

    /**
     * @ORM\Column(type="string",length=255, nullable=false)
     */
    private $value;

}