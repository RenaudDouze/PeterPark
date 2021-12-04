<?php

declare(strict_types = 1);

namespace Tests\PHPUnit\Infra\DTO;

use \Domain\Entity\Location;
use \Domain\Entity\Vehicle as VehicleEntity;
use \Infra\Database\DTO\Vehicle as VehicleDTO;
use \PHPUnit\Framework\TestCase;

class VehicleTest extends TestCase
{
    public function testCreateFromEntity() : void
    {
        $vehicle = new VehicleEntity('12-Douze-12');

        $dto = VehicleDTO::createFromEntity($vehicle);

        $this->assertEquals('12-Douze-12', $dto->plateNumber);
        $this->assertNull($dto->location);
    }

    public function testCreateFromEntityWithLocation() : void
    {
        $vehicle = new VehicleEntity('12-Douze-12');
        $location = new Location('R', '42');

        $vehicle->park($location);


        $dto = VehicleDTO::createFromEntity($vehicle);

        $this->assertEquals('12-Douze-12', $dto->plateNumber);
        $this->assertEquals($location, $dto->location);
    }
}
