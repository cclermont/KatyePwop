<?php

namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

use App\Traits\Core\Entity\CreatedModifiedTrait;

/**
 * @ORM\HasLifecycleCallbacks()
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
     * @ORM\OneToOne(targetEntity="Profile", cascade={"persist", "remove"})
     */
    private $profile;

    /**
     * Use Created modified trait
     */
    use CreatedModifiedTrait;

    /**
     * Constants
    */
    const ROLE_USER = "ROLE_USER";
    const ROLE_ADMIN = "ROLE_ADMIN";
    const ROLE_OPERATOR = "ROLE_OPERATOR";
    const ROLE_ROAD_AGENT = "ROLE_ROAD_AGENT";
    const ROLE_USER_SIMPLE = "ROLE_USER_SIMPLE";
    const ROLE_SUPER_ADMIN = "ROLE_SUPER_ADMIN";

    /**
     * Construct
    */
    public function __construct()
    {
        parent::__construct();

        $this->enabled = true;
        $this->profile = new Profile();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isSimpleUser(): ?bool
    {
        return $this->hasRole(self::ROLE_USER_SIMPLE);
    }

    public function isAdmin(): ?bool
    {
        return $this->hasRole(self::ROLE_OPERATOR) || $this->hasRole(self::ROLE_ADMIN);
    }

    public function isSuperAdmin(): ?bool
    {
        return $this->hasRole(self::ROLE_SUPER_ADMIN);
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): self
    {
        $this->profile = $profile;

        return $this;
    }

    public function getFormLabel(): string
    {
        $roles = implode(', ', $this->roles);
        return ucfirst("{$this->username} ({$roles})");
    }

    static public function getRolesList(): Array
    {
        return [
            self::ROLE_USER,
            self::ROLE_ADMIN,
            self::ROLE_OPERATOR,
            self::ROLE_ROAD_AGENT,
            self::ROLE_USER_SIMPLE,
            self::ROLE_SUPER_ADMIN,
        ];
    }
}
