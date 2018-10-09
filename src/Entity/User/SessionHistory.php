<?php

namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="user_session_history")
 * @ORM\Entity(repositoryClass="App\Repository\User\SessionHistoryRepository")
 */
class SessionHistory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $ip;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $context;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $system;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $deviceName;

    /**
     * @ORM\Column(type="string", length=8)
     */
    private $deviceVersion;

    /**
     * @ORM\Column(type="datetime")
     */
    private $opened;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $closed;
    
    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $user;
    
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Location\Location")
     */
    private $place;

    /**
     * Constants
     */
    const APP_CONTEXT     = 'app';
    const TABLET_CONTEXT  = 'tablet';
    const MOBILE_CONTEXT  = 'mobile';
    const BROWSER_CONTEXT = 'browser';


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function getContext(): ?string
    {
        return $this->context;
    }

    public function setContext(string $context): self
    {
        $this->context = $context;

        return $this;
    }

    public function getSystem(): ?string
    {
        return $this->system;
    }

    public function setSystem(string $system): self
    {
        $this->system = $system;

        return $this;
    }

    public function getDeviceName(): ?string
    {
        return $this->deviceName;
    }

    public function setDeviceName(string $deviceName): self
    {
        $this->deviceName = $deviceName;

        return $this;
    }

    public function getDeviceVersion(): ?string
    {
        return $this->deviceVersion;
    }

    public function setDeviceVersion(string $deviceVersion): self
    {
        $this->deviceVersion = $deviceVersion;

        return $this;
    }

    public function getOpened(): ?\DateTimeInterface
    {
        return $this->opened;
    }

    public function setOpened(\DateTimeInterface $opened): self
    {
        $this->opened = $opened;

        return $this;
    }

    public function getClosed(): ?\DateTimeInterface
    {
        return $this->closed;
    }

    public function setClosed(?\DateTimeInterface $closed): self
    {
        $this->closed = $closed;

        return $this;
    }
}
