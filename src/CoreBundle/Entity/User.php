<?php

namespace CoreBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\UserRepository")
 */
class User extends BaseUser{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="space_available", type="integer")
     */
    private $spaceAvailable;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->spaceAvailable = 30;
        $this->roles = array('ROLE_USER');

    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }




    /**
     * Set spaceAvailable
     *
     * @param integer $spaceAvailable
     *
     * @return User
     */
    public function setSpaceAvailable($spaceAvailable)
    {
        $this->spaceAvailable = $spaceAvailable;

        return $this;
    }

    /**
     * Get spaceAvailable
     *
     * @return integer
     */
    public function getSpaceAvailable()
    {
        return $this->spaceAvailable;
    }
}
