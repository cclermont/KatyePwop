<?php

namespace App\Entity\FleetManagement;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FleetManagement\FuelRepository")
 */
class Fuel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $pumped_at;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $merter_reading;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $qty_pumped;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $price_per_gallon;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $cost;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $last_mileage;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $driver_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FleetManagement\Vehicle", inversedBy="fuels")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vehicle;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPumpedAt(): ?\DateTimeInterface
    {
        return $this->pumped_at;
    }

    public function setPumpedAt(?\DateTimeInterface $pumped_at): self
    {
        $this->pumped_at = $pumped_at;

        return $this;
    }

    public function getMerterReading()
    {
        return $this->merter_reading;
    }

    public function setMerterReading($merter_reading): self
    {
        $this->merter_reading = $merter_reading;

        return $this;
    }

    public function getQtyPumped()
    {
        return $this->qty_pumped;
    }

    public function setQtyPumped($qty_pumped): self
    {
        $this->qty_pumped = $qty_pumped;

        return $this;
    }

    public function getPricePerGallon()
    {
        return $this->price_per_gallon;
    }

    public function setPricePerGallon($price_per_gallon): self
    {
        $this->price_per_gallon = $price_per_gallon;

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

    public function getLastMileage()
    {
        return $this->last_mileage;
    }

    public function setLastMileage($last_mileage): self
    {
        $this->last_mileage = $last_mileage;

        return $this;
    }

    public function getDriverId(): ?int
    {
        return $this->driver_id;
    }

    public function setDriverId(?int $driver_id): self
    {
        $this->driver_id = $driver_id;

        return $this;
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
}
