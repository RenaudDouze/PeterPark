<?php

namespace Tests\PHPUnit\Action\ParkVehicle;

use App\Action\ParkVehicle\DudeWheresMyCar;
use App\Action\ParkVehicle\Park;
use Domain\Entity\Location;
use Domain\Entity\Vehicle;
use PHPUnit\Framework\TestCase;

class ParkTest extends TestCase
{
    public function testDo()
    {
        $vehicle = new Vehicle();
        $location = new Location('ici', 'ici');

        $this->assertNull(DudeWheresMyCar::get($vehicle));

        Park::do($vehicle, $location);

        $this->assertEquals($location, DudeWheresMyCar::get($vehicle));
    }

    public function testDoException()
    {
        $vehicle = new Vehicle();
        $location = new Location('ici', 'ici');

        Park::do($vehicle, $location);

        $this->expectException(\RuntimeException::class);
        Park::do($vehicle, $location);
    }
}