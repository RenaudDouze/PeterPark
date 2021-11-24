<?php

namespace Tests\PHPUnit\Action\ParkVehicle;

use App\Action\ParkVehicle\DudeWheresMyCar;
use Domain\Entity\Location;
use Domain\Entity\Vehicle;
use PHPUnit\Framework\TestCase;

class DudeWheresMyCarTest extends TestCase
{
    public function testGet()
    {
        $vehicle = new Vehicle();

        $this->assertNull(DudeWheresMyCar::get($vehicle));

        $location = new Location('par', 'ici');
        $vehicle->park($location);
        
        $this->assertEquals($location, DudeWheresMyCar::get($vehicle));
    }
}
