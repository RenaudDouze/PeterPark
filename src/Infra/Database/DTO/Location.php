<?php

declare(strict_types = 1);

namespace Infra\Database\DTO;

use \Domain\Entity\Location as LocationEntity;

class Location
{
    public string $longitude;
    public string $latitude;

    public static function createFromEntity(LocationEntity $location) : self
    {
        $dto = new self();

        $dto->longitude = $location->getLongitude();
        $dto->latitude = $location->getLatitude();

        return $dto;
    }
}
