<?php

declare(strict_types = 1);

namespace Domain\Entity;

class Vehicle
{
    // Better with an uuid
    // The only purpose is to differentiate each Vehicle
    private string $id;
    private ?Location $location = null;

    public function __construct(?string $id = null)
    {
        $this->id = $id
            ?? \uniqid();
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
}
