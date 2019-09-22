<?php

namespace App\Entity\Message;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

use App\Entity\User\User;
use App\Entity\Location\Location;
use App\Entity\Institution\Institution;
use App\Traits\Core\Entity\CreatedModifiedTrait;

/**
 * @JMS\ExclusionPolicy("all")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="message_message")
 * @ORM\Entity(repositoryClass="App\Repository\Message\MessageRepository")
 */
class Message
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
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @JMS\Expose
     * @JMS\Groups({"list", "show"})
     */
    private $title;

    /**
     * @Assert\NotBlank(message="Le contenu ne peut pas être vide")
     * @ORM\Column(type="text")
     *
     * @JMS\Expose
     * @JMS\Groups({"list", "show"})
     */
    private $content;

    /**
     * @ORM\Column(type="integer")
     *
     * @JMS\Expose
     * @JMS\Groups({"show"})
     */
    private $status;

    /**
     * @ORM\Column(type="boolean")
     *
     * @JMS\Expose
     * @JMS\Groups({"show"})
     */
    private $broadcasted;

    /**
     * @ORM\Column(type="boolean")
     *
     * @JMS\Expose
     * @JMS\Groups({"show"})
     */
    private $regular; // Should repeat or not

    /**
     * @ORM\Column(type="boolean")
     *
     * @JMS\Expose
     * @JMS\Groups({"show"})
     */
    private $posponed;

    /**
     * @ORM\Column(type="boolean")
     *
     * @JMS\Expose
     * @JMS\Groups({"show"})
     */
    private $customRepeated;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $sendingDate;
    
    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="message", orphanRemoval=true, cascade={"persist", "remove"})
     *
     * @JMS\Expose
     * @JMS\MaxDepth(3)
     * @JMS\Groups({"show"})
     */
    private $images;
    
    /**
     * @ORM\OneToOne(targetEntity="Repeat", cascade={"persist", "remove"})
     *
     * @JMS\Expose
     * @JMS\MaxDepth(3)
     * @JMS\Groups({"show"})
     */
    private $repeat;
    
    /**
     * @ORM\OneToOne(targetEntity="Repeat", cascade={"persist", "remove"})
     *
     * @JMS\Expose
     * @JMS\MaxDepth(3)
     * @JMS\Groups({"show"})
     */
    private $customRepeat;
    
    /**
     * @ORM\OneToMany(targetEntity="Video", mappedBy="message", orphanRemoval=true, cascade={"persist", "remove"})
     *
     * @JMS\Expose
     * @JMS\MaxDepth(3)
     * @JMS\Groups({"show"})
     */
    private $videos;
    
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Location\Location")
     *
     * @ORM\JoinTable(name="message_message_location_join", 
     *      joinColumns={@ORM\JoinColumn(name="message_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="location_id", referencedColumnName="id", unique=false)})
     *
     * @ORM\OrderBy({"created" = "ASC"})
     *
     * @JMS\Expose
     * @JMS\Groups({"list", "show"})
     */
    private $locations;
    
    /**
     * @Assert\NotBlank(message="L'expediteur ne peut pas être vide")
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User")
     *
     * @JMS\Expose
     * @JMS\Groups({"list", "show"})
     */
    private $sender;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Institution\Institution")
     *
     * @JMS\Expose
     * @JMS\Groups({"list", "show"})
     * @JMS\SerializedName("senderInstitution")
     */
    private $senderInstitution;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Institution\Institution")
     *
     * @ORM\JoinTable(name="message_message_institution_join",
     *      joinColumns={@ORM\JoinColumn(name="message_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="institution_id", referencedColumnName="id", unique=true)})
     *
     * @ORM\OrderBy({"created" = "ASC"})
     */
    private $receivers;

    /**
     * Use Created modified trait
     */
    use CreatedModifiedTrait;


    public function __construct()
    {
        $this->status = "";
        $this->regular = false;
        $this->posponed = false;
        $this->broadcasted = false;
        $this->customRepeated = false;
        $this->sendingDate = New \Datetime();
        $this->images = new ArrayCollection();
        $this->videos = new ArrayCollection();
        $this->receivers = new ArrayCollection();
        $this->locations = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setMessage($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getMessage() === $this) {
                $image->setMessage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Video[]
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(Video $video): self
    {
        if (!$this->videos->contains($video)) {
            $this->videos[] = $video;
            $video->setMessage($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        if ($this->videos->contains($video)) {
            $this->videos->removeElement($video);
            // set the owning side to null (unless already changed)
            if ($video->getMessage() === $this) {
                $video->setMessage(null);
            }
        }

        return $this;
    }

    public function getSender(): ?User
    {
        return $this->sender;
    }

    public function setSender(?User $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getReceivers(): Collection
    {
        return $this->receivers;
    }

    public function addReceiver(User $receiver): self
    {
        if (!$this->receivers->contains($receiver)) {
            $this->receivers[] = $receiver;
        }

        return $this;
    }

    public function removeReceiver(User $receiver): self
    {
        if ($this->receivers->contains($receiver)) {
            $this->receivers->removeElement($receiver);
        }

        return $this;
    }

    public function getBroadcasted(): ?bool
    {
        return $this->broadcasted;
    }

    public function setBroadcasted(bool $broadcasted): self
    {
        $this->broadcasted = $broadcasted;

        return $this;
    }

    public function getSenderInstitution(): ?Institution
    {
        return $this->senderInstitution;
    }

    public function setSenderInstitution(?Institution $senderInstitution): self
    {
        $this->senderInstitution = $senderInstitution;

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

    public function getRegular(): ?bool
    {
        return $this->regular;
    }

    public function setRegular(bool $regular): self
    {
        $this->regular = $regular;

        return $this;
    }

    public function isSendingDateOver(): ?bool
    {
        return $this->sendingDate <= new \Datetime();
    }

    public function getSendingDate(): ?\DateTimeInterface
    {
        return $this->sendingDate;
    }

    public function setSendingDate(\DateTimeInterface $sendingDate): self
    {
        $this->sendingDate = $sendingDate;

        return $this;
    }

    public function getPosponed(): ?bool
    {
        return $this->posponed;
    }

    public function setPosponed(bool $posponed): self
    {
        $this->posponed = $posponed;

        return $this;
    }

    public function getCustomRepeated(): ?bool
    {
        return $this->customRepeated;
    }

    public function setCustomRepeated(bool $customRepeated): self
    {
        $this->customRepeated = $customRepeated;

        return $this;
    }

    public function getRepeat(): ?Repeat
    {
        return $this->repeat;
    }

    public function setRepeat(?Repeat $repeat): self
    {
        $this->repeat = $repeat;

        return $this;
    }

    public function getCustomRepeat(): ?Repeat
    {
        return $this->customRepeat;
    }

    public function setCustomRepeat(?Repeat $customRepeat): self
    {
        $this->customRepeat = $customRepeat;

        return $this;
    }
}
