<?php

declare(strict_types = 1);

namespace Domain\Entity;

class Vehicle
{
    // Better with an uuid
    // The only purpose is to differentiate each Vehicle
    /** @var \Domain\Entity\Location|null */
    private ?Location $location = null;

    public function __construct(
        private string $plateNumber,
    )
    {
    }

    public function whereIs() : ?Location
    {
        return $this->location;
    }

    public function park(Location $location) : void
    {
        if ($this->location === $location) {
            throw new \Infra\Exception\AlreadyParkedHere('Error Processing Request', 1);
        }

        $this->location = $location;
    }

    public function getPlateNumber() : string
    {
        return $this->plateNumber;
    }
}
