<?php

declare(strict_types = 1);

namespace Domain\Entity;

class Vehicle
{
    // Better with an uuid
    // The only purpose is to differentiate each Vehicle
    public const BEAN_NAME = 'vehicle';

    /** @var int|null Database id */
    private ?int $id = null;
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

    public function getId() : ?int
    {
        return $this->id;
    }

    public function setId(?int $id) : void
    {
        $this->id = $id;
    }
}
