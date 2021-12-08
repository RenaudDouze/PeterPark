<?php

declare(strict_types = 1);

namespace Tests\PHPUnit\Action\ParkVehicle;

use \App\Action\ParkVehicle\DudeWheresMyCar;
use \Domain\Entity\Location;
use \Domain\Entity\Vehicle;
use \PHPUnit\Framework\TestCase;

class DudeWheresMyCarTest extends TestCase
{
    public function testGet() : void
    {
        $vehicle = new Vehicle('one');

        $this->assertNull(DudeWheresMyCar::get($vehicle));

        $location = new Location('par', 'ici');
        $vehicle->park($location);

        $this->assertEquals($location, DudeWheresMyCar::get($vehicle));
    }

    public function testGetWithAltitude() : void
    {
        $vehicle = new Vehicle('one');

        $this->assertNull(DudeWheresMyCar::get($vehicle));

        $location = new Location('par', 'ici', 100);
        $vehicle->park($location);

        $this->assertEquals($location, DudeWheresMyCar::get($vehicle));
    }
}
