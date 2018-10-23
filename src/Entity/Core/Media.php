<?php

namespace App\Entity\Core;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;

use App\Traits\Core\Entity\CreatedModifiedTrait;

/**
 * @ORM\MappedSuperclass
 * @JMS\ExclusionPolicy("all")
 * @ORM\HasLifecycleCallbacks()
 */
abstract class Media
{
    /**
     * @ORM\Embedded(class="Vich\UploaderBundle\Entity\File")
     *
     * @var EmbeddedFile
     */
    protected $info;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $description;

    /**
     * Use Created modified trait
     */
    use CreatedModifiedTrait;


    public function __construct()
    {
        $this->info = new EmbeddedFile();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInfo(): EmbeddedFile
    {
        return $this->info;
    }

    public function setInfo(EmbeddedFile $info): self
    {
        $this->info = $info;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function isEmpty(): bool
    {
        return null == $this->info->getName();
    }
    
    /**
     * Get Relative Filename
     *
     * @return String 
     *
     * @JMS\Expose
     * @JMS\VirtualProperty
     * @JMS\Groups({"show"})
     * @JMS\SerializedName("path")
     */
    public function getRelativePath(): string
    {
        
        return "{$this->getRelativeDir()}/{$this->info->getName()}";
    }
    
    /**
     * Get Relative Directory
     *
     * @return String 
     */
    abstract public function getRelativeDir(): string;
}
