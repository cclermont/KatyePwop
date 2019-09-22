<?php

namespace App\Entity\Message;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @JMS\ExclusionPolicy("all")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="message_message_repeat")
 * @ORM\Entity(repositoryClass="App\Repository\Message\RepeatRepository")
 */
class Repeat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     *
     * @JMS\Expose
     * @JMS\Groups({"show"})
     */
    private $custom;

    /**
     * @Assert\NotBlank(message="La frequence ne peut pas être vide")
     * @ORM\Column(type="string", length=16)
     */
    private $frequency;

    /**
     * @Assert\NotBlank(message="Ce champs ne peut pas être vide")
     * @ORM\Column(type="integer")
     */
    private $every;

    /**
     * @ORM\Column(type="array")
     */
    private $weekDays = [];

    /**
     * @ORM\Column(type="array")
     */
    private $monthDays = [];

    /**
     * @ORM\Column(type="array")
     */
    private $yearMonths = [];

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;


    public function __construct()
    {
        $this->custom = true;
        $this->created = new \Datetime();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFrequency(): ?string
    {
        return $this->frequency;
    }

    public function setFrequency(string $frequency): self
    {
        $this->frequency = $frequency;

        return $this;
    }

    public function getEvery(): ?int
    {
        return $this->every;
    }

    public function setEvery(int $every): self
    {
        $this->every = $every;

        return $this;
    }

    public function getWeekDays(): ?array
    {
        return $this->weekDays;
    }

    public function setWeekDays(array $weekDays): self
    {
        $this->weekDays = $weekDays;

        return $this;
    }

    public function getMonthDays(): ?array
    {
        return $this->monthDays;
    }

    public function setMonthDays(array $monthDays): self
    {
        $this->monthDays = $monthDays;

        return $this;
    }

    public function getYearMonths(): ?array
    {
        return $this->yearMonths;
    }

    public function setYearMonths(array $yearMonths): self
    {
        $this->yearMonths = $yearMonths;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function isCustom(): ?bool
    {
        return $this->custom;
    }

    public function setCustom(bool $custom): self
    {
        $this->custom = $custom;

        return $this;
    }
}
