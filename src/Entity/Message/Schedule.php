<?php

namespace App\Entity\Message;

use App\Entity\Location\Location;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

use App\Traits\Core\Entity\CreatedModifiedTrait;

/**
 * @JMS\ExclusionPolicy("all")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="message_schedule")
 * @ORM\Entity(repositoryClass="App\Repository\Message\ScheduleRepository")
 */
class Schedule
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
     * @ORM\Column(type="string", length=16)
     *
     * @JMS\Expose
     * @JMS\Groups({"list", "show"})
     */
    private $day;

    /**
     * @ORM\Column(type="time", nullable=true)
     *
     * @JMS\Expose
     * @JMS\Type("DateTime<'h:i A'>")
     * @JMS\Groups({"list", "show"})
     */
    private $time;
    
    /**
     * @Assert\NotBlank(message="La localité ne peut pas être vide")
     * @ORM\ManyToOne(targetEntity="App\Entity\Location\Location")
     *
     * @JMS\Expose
     * @JMS\MaxDepth(3)
     * @JMS\Groups({"show"})
     */
    private $location;

    /**
     * Use Created modified trait
     */
    use CreatedModifiedTrait;


    public function __construct()
    {
        $this->time = new \Datetime;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(?\DateTimeInterface $time): self
    {
        $this->time = $time;

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
}
