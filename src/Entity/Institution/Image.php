<?php

namespace App\Entity\Institution;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Core\Media;

/**
 * @ORM\Table(name="institution_image")
 * @ORM\Entity(repositoryClass="App\Repository\Institution\ImageRepository")
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
