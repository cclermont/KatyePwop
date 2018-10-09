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

    public function getId(): ?int
    {
        return $this->id;
    }
}