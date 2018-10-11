<?php

namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Table(name="user_user")
 * @ORM\Entity(repositoryClass="App\Repository\User\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $blocked;
    
    /**
     * @ORM\OneToOne(targetEntity="Profile")
     */
    private $profile;

    /**
     * Constants
    */
    const ROLE_USER = "ROLE_USER";
    const ROLE_ADMIN = "ROLE_ADMIN";
    const ROLE_OPERATOR = "ROLE_OPERATOR";
    const ROLE_ROAD_AGENT = "ROLE_ROAD_AGENT";
    const ROLE_SUPER_ADMIN = "ROLE_SUPER_ADMIN";

    /**
     * Construct
    */
    public function __construct()
    {
        parent::__construct();

        $this->blocked = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBlocked(): ?bool
    {
        return $this->blocked;
    }

    public function setBlocked(bool $blocked): self
    {
        $this->blocked = $blocked;

        return $this;
    }
}
