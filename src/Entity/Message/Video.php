<?php

namespace App\Entity\Message;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Core\Media;

/**
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
}
