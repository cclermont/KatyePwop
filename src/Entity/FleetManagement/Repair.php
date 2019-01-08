<?php

namespace App\Entity\FleetManagement;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FleetManagement\RepairRepository")
 */
class Repair
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FleetManagement\Vehicle")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vehicle;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $supplier;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $payment_ref;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $cost;

    /**
     * @ORM\Column(type="text")
     */
    private $remarks;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(?Vehicle $vehicle): self
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getSupplier(): ?string
    {
        return $this->supplier;
    }

    public function setSupplier(string $supplier): self
    {
        $this->supplier = $supplier;

        return $this;
    }

    public function getPaymentRef(): ?string
    {
        return $this->payment_ref;
    }

    public function setPaymentRef(?string $payment_ref): self
    {
        $this->payment_ref = $payment_ref;

        return $this;
    }

    public function getCost()
    {
        return $this->cost;
    }

    public function setCost($cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    public function getRemarks(): ?string
    {
        return $this->remarks;
    }

    public function setRemarks(string $remarks): self
    {
        $this->remarks = $remarks;

        return $this;
    }
}
