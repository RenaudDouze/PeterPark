<?php

namespace Tests\PHPUnit\Domain\Entity;

use Domain\Entity\Location;
use Domain\Entity\Vehicle;
use Infra\Exception\AlreadyParkedHereException;
use PHPUnit\Framework\TestCase;

class VehicleTest extends TestCase
{
    public function testConstructor()
    {
        $vehicleOne = new Vehicle('one');
        $vehicleTwo = new Vehicle('two');
        $vehicleOneSame = new Vehicle('one');
        
        $this->assertEquals($vehicleOne, $vehicleOneSame);
        $this->assertNotSame($vehicleOne, $vehicleTwo);
    }

    public function testWhereIs()
    {
        $vehicle = new Vehicle();

        $this->assertNull($vehicle->whereIs());

        $location = new Location('D', '12');
        $vehicle->park($location);

        $this->assertEquals($location, $vehicle->whereIs());
    }

    public function testPark()
    {
        $vehicle = new Vehicle();
        $locationD12 = new Location('D', '12');
        $locationE1 = new Location('E', '1');

        $vehicle->park($locationD12);
        $vehicle->park($locationE1);

        $this->expectException(AlreadyParkedHereException::class);
        $vehicle->park($locationE1);
    }
}
