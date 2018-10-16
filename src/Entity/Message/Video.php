<?php

namespace App\Entity\Message;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

use App\Entity\Core\Media;

/**
 * @Vich\Uploadable
 * @ORM\Table(name="message_video")
 * @ORM\Entity(repositoryClass="App\Repository\Message\VideoRepository")
 */
class Video extends Media
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $length;
    
    /**
     * @ORM\ManyToOne(targetEntity="Message", inversedBy="videos")
     */
    private $message;

    /**
     * @Vich\UploadableField(mapping="message_video", fileNameProperty="info.name", size="info.size", mimeType="info.mimeType", originalName="info.originalName", dimensions="info.dimensions")
     * 
     * @var File
     */
    private $file;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLength(): ?int
    {
        return $this->length;
    }

    public function setLength(int $length): self
    {
        $this->length = $length;

        return $this;
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

    /**
     * @param File|UploadedFile $file
     */
    public function setFile(?File $file = null)
    {
        $this->file = $file;

        if (null !== $file) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->modified = new \DateTimeImmutable();
        }
    }

    public function getFile(): ?File
    {
        return $this->file;
    }
    
    /**
     * Get Relative Directory
     *
     * @return String 
     */
    public function getRelativeDir(): string
    {
        return '/uploads/videos/message';
    }
}
