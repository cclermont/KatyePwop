<?php

namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

use App\Entity\Location\Location;
use App\Traits\Core\Entity\CreatedModifiedTrait;

/**
 * @JMS\ExclusionPolicy("all")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="user_profile")
 * @ORM\Entity(repositoryClass="App\Repository\User\ProfileRepository")
 */
class Profile
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @JMS\Expose
     * @JMS\Groups({"show"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     *
     * @JMS\Expose
     * @JMS\Groups({"show"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     *
     * @JMS\Expose
     * @JMS\Groups({"show"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     *
     * @JMS\Expose
     * @JMS\Groups({"show"})
     */
    private $gender;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthdate;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     *
     * @JMS\Expose
     * @JMS\Groups({"show"})
     */
    private $phone;
    
    /**
     * @ORM\OneToOne(targetEntity="Image", cascade={"persist", "remove"})
     *
     * @JMS\Expose
     * @JMS\Groups({"show"})
     */
    private $image;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location\Location")
     *
     * @JMS\Expose
     * @JMS\Groups({"show"})
     */
    private $location;

    /**
     * Use Created modified trait
     */
    use CreatedModifiedTrait;

    /**
     * Constants
    */
    const MIN_YEAR_OLD = 6;
    const MAX_YEAR_OLD = 120;
    const GENDER_MALE = "male";
    const GENDER_FEMALE = "female";

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(?\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

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

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }
    
}
