<?php

declare(strict_types = 1);

namespace Tests\PHPUnit\Infra\Database\Dto;

use \Domain\Entity\Fleet as EntityAlias;
use \Domain\Entity\Vehicle;
use \Infra\Database\Dto\Fleet as FleetDTO;
use \PHPUnit\Framework\TestCase;

class FleetTest extends TestCase
{
    public function testCreateFromEntity() : void
    {
        $fleet = new EntityAlias('Jaune Attends');

        $fleetDTO = FleetDTO::createFromEntity($fleet);

        $this->assertEquals('Jaune Attends', $fleetDTO->ownerId);
        $this->assertEquals([], $fleetDTO->vehicles);
    }

    public function testCreateFromEntityWithVehicles() : void
    {
        $fleet = new EntityAlias('Jaune Attends');
        $vehicleOne = new Vehicle('one');
        $vehicleTwo = new Vehicle('two');

        $fleet->add($vehicleOne);
        $fleet->add($vehicleTwo);

        $fleetDTO = FleetDTO::createFromEntity($fleet);

        $this->assertEquals('Jaune Attends', $fleetDTO->ownerId);
        $this->assertEquals([$vehicleOne, $vehicleTwo], $fleetDTO->vehicles);
    }
}
