<?php

namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Core\Media;

/**
 * @ORM\Table(name="user_image")
 * @ORM\Entity(repositoryClass="App\Repository\User\ImageRepository")
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
