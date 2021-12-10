<?php

declare(strict_types = 1);

namespace Domain\Entity;

class Fleet
{
    public const BEAN_NAME = 'fleet';

    /** @var int|null Database id */
    private ?int $id = null;
    /** @var array<\Domain\Entity\Vehicle>  */
    private array $vehicles = [];

    public function __construct(
        private string $ownerId,
    )
    {
    }

    public function add(Vehicle $vehicle) : int
    {
        if ($this->isIn($vehicle)) {
            throw new \Infra\Exception\AlreadyInFleet();
        }

        $this->vehicles[] = $vehicle;

        return \count($this->vehicles);
    }

    public function isIn(Vehicle $vehicle) : bool
    {
        return \in_array($vehicle, $this->vehicles);
    }

    public function getOwnerId() : string
    {
        return $this->ownerId;
    }

    /**
     * @return array<\Domain\Entity\Vehicle>
     */
    public function getVehicles() : array
    {
        return $this->vehicles;
    }

    public function getId() : ?int
    {
        return $this->id;
    }

    public function setId(?int $id) : void
    {
        $this->id = $id;
    }
}
