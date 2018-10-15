<?php

namespace App\Entity\Message;

use App\Entity\Institution\Institution;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

use App\Entity\User\User;
use App\Entity\Location\Location;
use App\Traits\Core\Entity\CreatedModifiedTrait;

/**
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
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="boolean")
     */
    private $broadcasted;
    
    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="message", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $images;
    
    /**
     * @ORM\OneToMany(targetEntity="Video", mappedBy="message", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $videos;
    
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Location\Location")
     */
    private $place;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User")
     */
    private $sender;

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
        $this->broadcasted = false;
        $this->images = new ArrayCollection();
        $this->videos = new ArrayCollection();
        $this->receivers = new ArrayCollection();
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

    public function getPlace(): ?Location
    {
        return $this->place;
    }

    public function setPlace(?Location $place): self
    {
        $this->place = $place;

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
}
