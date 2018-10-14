<?php

namespace App\Entity\Institution;

use App\Entity\Location\Location;
use App\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use App\Traits\Core\Entity\CreatedModifiedTrait;

/**
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
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enabled;
    
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Location\Location")
     */
    private $place;
    
    /**
     * @ORM\OneToOne(targetEntity="Image", cascade={"persist", "remove"})
     */
    private $brand;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User")
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

    public function getPlace(): ?Location
    {
        return $this->place;
    }

    public function setPlace(?Location $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getBrand(): ?Image
    {
        return $this->brand;
    }

    public function setBrand(?Image $brand): self
    {
        $this->brand = $brand;

        return $this;
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
