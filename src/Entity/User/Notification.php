<?php

namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="user_notification")
 * @ORM\Entity(repositoryClass="App\Repository\User\NotificationRepository")
 */
class Notification
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
    private $firebaseAndroidToken;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firebaseIosToken;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirebaseAndroidToken(): ?string
    {
        return $this->firebaseAndroidToken;
    }

    public function setFirebaseAndroidToken(?string $firebaseAndroidToken): self
    {
        $this->firebaseAndroidToken = $firebaseAndroidToken;

        return $this;
    }

    public function getFirebaseIosToken(): ?string
    {
        return $this->firebaseIosToken;
    }

    public function setFirebaseIosToken(?string $firebaseIosToken): self
    {
        $this->firebaseIosToken = $firebaseIosToken;

        return $this;
    }
}
