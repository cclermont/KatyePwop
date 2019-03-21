<?php

namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use App\Traits\Core\Entity\CreatedModifiedTrait;

/**
 * @UniqueEntity("email", message="L'email choisi est deja utitlisé")
 * @UniqueEntity("username", message="Le nom d'utilisateur choisi est deja utitlisé")
 * @JMS\ExclusionPolicy("all")
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
     *
     * @JMS\Expose
     * @JMS\Groups({"list", "show"})
     */
    protected $id;

    /**
     * @var string
     * 
     * @Assert\Regex(pattern="/\s+/", match=false, message="Le nom d'utilisateur ne doit pas avoir d'espace")
     * @Assert\Regex(pattern="/^[^a-zA-z]/", match=false, message="Le nom d'utilisateur ne doit pas avoir uniquement des chiffres")
     * @Assert\Regex(pattern="/[\# \! \^ \$ \( \) \[ \] \{ \} \? \+ \* \. \\ \/ \|]/", match=false, message="Le nom d'utilisateur ne doit pas avoir de caractères speciaux")
     *
     * @JMS\Expose
     * @JMS\Groups({"list", "show"})
     */
    protected $username;

    /**
     * @var string
     *
     * @JMS\Expose
     * @JMS\Groups({"show"})
     */
    protected $email;

    /**
     * @var string
     * 
     * @Assert\Regex(pattern="/(\W|\w){6,}/", match=true, message="Le mot de passe doit avoir 6 caractères au minimum")
     * @Assert\Regex(pattern="/[A-Z]+/", match=true, message="Le mot de passe doit avoir une majuscule au minimum")
     * @Assert\Regex(pattern="/[0-9]+/", match=true, message="Le mot de passe doit avoir un chiffre au minimum")
     */
    protected $plainPassword;
    
    /**
     * @ORM\OneToOne(targetEntity="Profile", cascade={"persist", "remove"})
     *
     * @JMS\Expose
     * @JMS\MaxDepth(3)
     * @JMS\Groups({"show"})
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

    /**
     * Get birthdateTimestamp
     *
     * @return \integer
     *
     * @JMS\Expose
     * @JMS\VirtualProperty
     * @JMS\Groups({"show"})
     * @JMS\SerializedName("lastLogin")
     */
    public function getLastLoginTimestamp(): int
    {
        return null == $this->lastLogin ? 0 : $this->lastLogin->getTimestamp() * 1000;
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
