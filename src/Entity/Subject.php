<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Subject
 *
 * @ORM\Table(name="subject")
 * @ORM\Entity(repositoryClass="App\Repository\SubjectRepository")
 */
class Subject
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="subjects", cascade={"persist"})
     */

    private $users;

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
     * Get the value of users
     */
    public function getUsers()
    {
        return $this->users;
    }
      /**
     * Add users
     *
     * @return self
     */
    public function addUser(\App\Entity\User $user)
    {
        $this->users[] = $user;
        if(!$user->getSubjects()->contains($this)){
            $user->addSubject($this);
        }

        return $this;
    }


    /** Remove users
     *
     * @param \App\Entity\User $users
     */
    public function removeUsers(\App\Entity\User $users)
    {
        $this->users->removeElement($users);
        $users->removeSubjects($this);
    }

    public function __toString()
    {
        return $this->title;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
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
     * Get the value of title
     *
     * @return  string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @param  string  $title
     *
     * @return  self
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }



    // /**
    //  * Set the value of users
    //  *
    //  * @return  self
    //  */
    // public function setUsers($users)
    // {
    //     $this->users = $users;

    //     return $this;
    // }


}
