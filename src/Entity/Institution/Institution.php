<?php

namespace App\Entity\Institution;

use Doctrine\ORM\Mapping as ORM;

/**
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
     * @ORM\OneToOne(targetEntity="Image")
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
     * Constants
    */
    const TYPE_PUBLIC = 0;
    const TYPE_PRIVATE = 1;


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
}
