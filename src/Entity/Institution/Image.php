<?php

namespace App\Entity\Institution;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

use App\Entity\Core\Media;

/**
 * @Vich\Uploadable
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

    /**
     * @Vich\UploadableField(mapping="institution_brand", fileNameProperty="info.name", size="info.size", mimeType="info.mimeType", originalName="info.originalName", dimensions="info.dimensions")
     * 
     * @var File
     */
    private $file;


    public function getId(): ?int
    {
        return $this->id;
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
}
