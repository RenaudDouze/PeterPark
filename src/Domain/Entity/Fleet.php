<?php

declare(strict_types = 1);

namespace Domain\Entity;

class Fleet
{
    /** @var array<\Domain\Entity\Vehicle>  */
    private array $vehicles = [];

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
}
