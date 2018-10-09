<?php

namespace App\Entity\Message;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Core\Media;

/**
 * @ORM\Table(name="message_image")
 * @ORM\Entity(repositoryClass="App\Repository\Message\ImageRepository")
 */
class Image extends Media
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Message", inversedBy="images")
     */
    private $message;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?Message
    {
        return $this->message;
    }

    public function setMessage(?Message $message): self
    {
        $this->message = $message;

        return $this;
    }
}