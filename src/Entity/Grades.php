<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table(name="grades")
 * @ORM\Entity(repositoryClass="App\Repository\GradesRepository")
 */
class Grades
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="grade", type="float", nullable=false)
     * @Assert\NotBlank()
     */
    private $grade;

    /**
     * @var text
     *
     * @ORM\Column(name="commentary", type="text")
     * @Assert\NotBlank()
     */
    private $commentary;

    /**
     * @ORM\ManyToOne(targetEntity="User", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */

    protected $users;

    /**
     * @ORM\ManyToOne(targetEntity="Subject", cascade={"persist"})
     * @ORM\JoinColumn(name="subject_id", referencedColumnName="id")
     */

    protected $subjects;

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tickets = new \Doctrine\Common\Collections\ArrayCollection();
        $this->messages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->role = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Get the value of users
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set the value of users
     *
     * @return  self
     */
    public function setUsers($users)
    {
        $this->users = $users;

        return $this;
    }

    public function __toString()
    {
        return $this->title;
    }

    /**
     * Get the value of subjects
     */
    public function getSubjects()
    {
        return $this->subjects;
    }

    /**
     * Set the value of subjects
     *
     * @return  self
     */
    public function setSubjects($subjects)
    {
        $this->subjects = $subjects;

        return $this;
    }

    /**
     * Get the value of number
     *
     * @return  int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set the value of number
     *
     * @param  int  $number
     *
     * @return  self
     */
    public function setNumber(int $number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get the value of average
     *
     * @return  float
     */
    public function getAverage()
    {
        return $this->average;
    }

    /**
     * Set the value of average
     *
     * @param  float  $average
     *
     * @return  self
     */
    public function setAverage(float $average)
    {
        $this->average = $average;

        return $this;
    }
}
