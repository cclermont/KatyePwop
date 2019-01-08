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
     * @ORM\Column(type="string", length=255)
     *
     * @JMS\Expose
     * @JMS\Groups({"show"})
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @JMS\Expose
     * @JMS\Groups({"show"})
     */
    private $slogan;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @JMS\Expose
     * @JMS\Groups({"show"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @JMS\Expose
     * @JMS\Groups({"show"})
     */
    private $website;

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
     * @ORM\Column(type="boolean")
     */
    private $allLocationAccess;
    
    /**
     * @ORM\OneToOne(targetEntity="Person", cascade={"persist", "remove"})
     */
    private $mayor;
    
    /**
     * @Assert\NotBlank()
     * @ORM\OneToOne(targetEntity="App\Entity\Location\Location", cascade={"persist", "remove"})
     */
    private $address;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Location\Location", mappedBy="institution", orphanRemoval=true, cascade={"persist", "remove"})
     *
     * @JMS\Expose
     * @JMS\MaxDepth(3)
     * @JMS\Groups({"show"})
     */
    private $locations;
    
    /**
     * @ORM\OneToOne(targetEntity="Image", cascade={"persist", "remove"})
     */
    private $image;
    
    /**
     * @Assert\NotBlank()
     * @ORM\OneToOne(targetEntity="App\Entity\User\User", cascade={"persist", "remove"})
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
        $this->enabled = false;
        $this->allLocationAccess = false;
        $this->members = new ArrayCollection();
        $this->locations = new ArrayCollection();
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

    public function getAllLocationAccess(): ?bool
    {
        return $this->allLocationAccess;
    }

    public function setAllLocationAccess(bool $allLocationAccess): self
    {
        $this->allLocationAccess = $allLocationAccess;

        return $this;
    }

    /**
     * @return Collection|Location[]
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function addLocation(Location $location): self
    {
        if (!$this->locations->contains($location)) {
            $this->locations[] = $location;
        }

        return $this;
    }

    public function removeLocation(Location $location): self
    {
        if ($this->locations->contains($location)) {
            $this->locations->removeElement($location);
        }

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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getSlogan(): ?string
    {
        return $this->slogan;
    }

    public function setSlogan(string $slogan): self
    {
        $this->slogan = $slogan;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getMayor(): ?Person
    {
        return $this->mayor;
    }

    public function setMayor(?Person $mayor): self
    {
        $this->mayor = $mayor;

        return $this;
    }

    public function getAddress(): ?Location
    {
        return $this->address;
    }

    public function setAddress(?Location $address): self
    {
        $this->address = $address;

        return $this;
    }
}
