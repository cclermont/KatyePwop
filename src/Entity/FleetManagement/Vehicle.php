<?php

namespace App\Entity\FleetManagement;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FleetManagement\VehicleRepository")
 */
class Vehicle
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $reg_no;

    /**
     * @ORM\Column(type="integer")
     */
    private $category_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $institution_id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $reg_date;

    /**
     * @ORM\Column(type="decimal", precision=13, scale=2, nullable=true)
     */
    private $cost;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $make;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $model;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $assigned_driver_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FleetManagement\VehicleCategory", inversedBy="vehicles")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FleetManagement\Fuel", mappedBy="vehicle")
     */
    private $fuels;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FleetManagement\Maintenance", mappedBy="vehicle")
     */
    private $maintenances;

    public function __construct()
    {
        $this->fuels = new ArrayCollection();
        $this->maintenances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegNo(): ?string
    {
        return $this->reg_no;
    }

    public function setRegNo(?string $reg_no): self
    {
        $this->reg_no = $reg_no;

        return $this;
    }

    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }

    public function setCategoryId(int $category_id): self
    {
        $this->category_id = $category_id;

        return $this;
    }

    public function getInstitutionId(): ?int
    {
        return $this->category_id;
    }

    public function setInstitutionId(int $institution_id): self
    {
        $this->institution_id = $institution_id;

        return $this;
    }

    public function getRegDate(): ?\DateTimeInterface
    {
        return $this->reg_date;
    }

    public function setRegDate(?\DateTimeInterface $reg_date): self
    {
        $this->reg_date = $reg_date;

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

    public function getMake(): ?string
    {
        return $this->make;
    }

    public function setMake(?string $make): self
    {
        $this->make = $make;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(?string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getAssignedDriverId(): ?int
    {
        return $this->assigned_driver_id;
    }

    public function setAssignedDriverId(?int $assigned_driver_id): self
    {
        $this->assigned_driver_id = $assigned_driver_id;

        return $this;
    }

    public function getCategory(): ?VehicleCategory
    {
        return $this->category;
    }

    public function setCategory(?VehicleCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Fuel[]
     */
    public function getFuels(): Collection
    {
        return $this->fuels;
    }

    public function addFuel(Fuel $fuel): self
    {
        if (!$this->fuels->contains($fuel)) {
            $this->fuels[] = $fuel;
            $fuel->setVehicle($this);
        }

        return $this;
    }

    public function removeFuel(Fuel $fuel): self
    {
        if ($this->fuels->contains($fuel)) {
            $this->fuels->removeElement($fuel);
            // set the owning side to null (unless already changed)
            if ($fuel->getVehicle() === $this) {
                $fuel->setVehicle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Maintenance[]
     */
    public function getMaintenances(): Collection
    {
        return $this->maintenances;
    }

    public function addMaintenance(Maintenance $maintenance): self
    {
        if (!$this->maintenances->contains($maintenance)) {
            $this->maintenances[] = $maintenance;
            $maintenance->setVehicle($this);
        }

        return $this;
    }

    public function removeMaintenance(Maintenance $maintenance): self
    {
        if ($this->maintenances->contains($maintenance)) {
            $this->maintenances->removeElement($maintenance);
            // set the owning side to null (unless already changed)
            if ($maintenance->getVehicle() === $this) {
                $maintenance->setVehicle(null);
            }
        }

        return $this;
    }
}
