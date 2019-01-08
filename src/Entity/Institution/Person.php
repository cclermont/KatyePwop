<?php

namespace App\Entity\Institution;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

use App\Traits\Core\Entity\CreatedModifiedTrait;

/**
 * @JMS\ExclusionPolicy("all")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="institution_person")
 * @ORM\Entity(repositoryClass="App\Repository\Institution\PersonRepository")
 */
class Person
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
     * @ORM\Column(type="string", length=128)
     *
     * @JMS\Expose
     * @JMS\Groups({"list", "show"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=128)
     *
     * @JMS\Expose
     * @JMS\Groups({"list", "show"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     *
     * @JMS\Expose
     * @JMS\Groups({"show"})
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     *
     * @JMS\Expose
     * @JMS\Groups({"show"})
     */
    private $email;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @JMS\Expose
     * @JMS\Groups({"show"})
     */
    private $bio;
    

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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }
}
