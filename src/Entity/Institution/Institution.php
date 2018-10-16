<?php

namespace App\Entity\Institution;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

use App\Entity\User\User;
use App\Entity\Location\Location;
use App\Traits\Core\Entity\CreatedModifiedTrait;

/**
 * @JMS\ExclusionPolicy("all")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="institution_institution")
 * @ORM\Entity(repositoryClass="App\Repository\Institution\InstitutionRepository")
 */
class Institution
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @JMS\Expose
     * @JMS\Groups({"list", "show"})
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     *
     * @JMS\Expose
     * @JMS\Groups({"list", "show"})
     */
    private $name;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enabled;
    
    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="App\Entity\Location\Location")
     */
    private $location;
    
    /**
     * @ORM\OneToOne(targetEntity="Image", cascade={"persist", "remove"})
     */
    private $image;
    
    /**
     * @Assert\NotBlank()
     * @ORM\OneToOne(targetEntity="App\Entity\User\User")
     */
    private $admin;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User\User")
     *
     * @ORM\JoinTable(name="institution_institution_user_join", 
     *      joinColumns={@ORM\JoinColumn(name="institution_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", unique=true)})
     *
     * @ORM\OrderBy({"created" = "ASC"})
     */
    private $members;

    /**
     * Use Created modified trait
     */
    use CreatedModifiedTrait;

    /**
     * Constants
    */
    const TYPE_PRIVATE = 0;
    const TYPE_GOVERNMENTAL = 1;


    public function __construct()
    {
        $this->members = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function hasImage(): bool
    {
        return null != $this->image && !$this->image->isEmpty();
    }

    public function getAdmin(): ?User
    {
        return $this->admin;
    }

    public function setAdmin(?User $admin): self
    {
        $this->admin = $admin;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(User $member): self
    {
        if (!$this->members->contains($member)) {
            $this->members[] = $member;
        }

        return $this;
    }

    public function removeMember(User $member): self
    {
        if ($this->members->contains($member)) {
            $this->members->removeElement($member);
        }

        return $this;
    }

    public function hasMember(User $member): bool
    {
        return $this->members->contains($member);
    }

    /**
     * @return Collection|User[]
     */
    public function getAdministrators(): Collection
    {
        return $this->members->filter(function($item){ return $item->hasRole(User::ROLE_ADMIN); });
    }

    /**
     * @return Collection|User[]
     */
    public function getOperators(): Collection
    {
        return $this->members->filter(function($item){ return $item->hasRole(User::ROLE_OPERATOR); });
    }

    /**
     * @return Collection|User[]
     */
    public function getRoadAgents(): Collection
    {
        return $this->members->filter(function($item){ return $item->hasRole(User::ROLE_ROAD_AGENT); });
    }

    public function getTypeName()
    {
        switch ($this->type) {
            case self::TYPE_PRIVATE:
                return 'Privée';
            default:
                return 'Gouvernementale';
        }
    }
}
