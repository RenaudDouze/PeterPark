<?php

declare(strict_types = 1);

namespace Infra\Database\DTO;

use \Domain\Entity\Location;
use \Domain\Entity\Vehicle as VehicleEntity;

class Vehicle
{
    public ?Location $location = null;
    public string $plateNumber;

    public static function createFromEntity(VehicleEntity $vehicle) : self
    {
        $dto = new self();

        $dto->location = $vehicle->whereIs();
        $dto->plateNumber = $vehicle->getPlateNumber();

        return $dto;
    }
}
