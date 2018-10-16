<?php

namespace App\Traits\Core\Entity;

use JMS\Serializer\Annotation as JMS;

/**
 * CreatedModifiedTrait
 *
 * @JMS\ExclusionPolicy("all")
 */
trait CreatedModifiedTrait
{

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $modified;


    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get CreatedTimestamp
     *
     * @return \integer
     *
     * @JMS\Expose
     * @JMS\VirtualProperty
     * @JMS\Groups({"list", "show"})
     * @JMS\SerializedName("created")
     */
    public function getCreatedTimestamp(): int
    {
        return null == $this->created ? 0 : $this->created->getTimestamp() * 1000;
    }

    public function getModified(): ?\DateTimeInterface
    {
        return $this->modified;
    }

    public function setModified(\DateTimeInterface $modified): self
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function onCreate()
    {
        $this->created = new \DateTime();
        $this->modified = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function onUpdate()
    {
        $this->modified = new \DateTime();
    }
}