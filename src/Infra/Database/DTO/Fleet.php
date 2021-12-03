<?php

declare(strict_types = 1);

namespace Infra\Database\DTO;

use \Domain\Entity\Fleet as FleetEntity;

class Fleet
{
    public string $ownerId;
    public array $vehicles = [];

    public static function createFromEntity(FleetEntity $fleet) : self
    {
        $dto = new self();

        $dto->ownerId = $fleet->getOwnerId();
        $dto->vehicles = $fleet->getVehicles();

        return $dto;
    }
}
