<?php

declare(strict_types = 1);

namespace Tests\PHPUnit\Action\ParkVehicle;

use \App\Action\ParkVehicle\DudeWheresMyCar;
use \App\Action\ParkVehicle\Park;
use \Domain\Entity\Location;
use \Domain\Entity\Vehicle;
use \PHPUnit\Framework\TestCase;

class ParkTest extends TestCase
{
    public function testDo() : void
    {
        $vehicle = new Vehicle('one');
        $location = new Location('ici', 'ici');

        $this->assertNull(DudeWheresMyCar::get($vehicle));

        Park::do($vehicle, $location);

        $this->assertEquals($location, DudeWheresMyCar::get($vehicle));
    }

    public function testDoWithAltitude() : void
    {
        $vehicle = new Vehicle('one');
        $location = new Location('ici', 'ici', 42);

        $this->assertNull(DudeWheresMyCar::get($vehicle));

        Park::do($vehicle, $location);

        $this->assertEquals($location, DudeWheresMyCar::get($vehicle));
    }

    public function testDoException() : void
    {
        $vehicle = new Vehicle('one');
        $location = new Location('ici', 'ici');

        Park::do($vehicle, $location);

        $this->expectException(\RuntimeException::class);
        Park::do($vehicle, $location);
    }

    public function testDoWithAltitudeException() : void
    {
        $vehicle = new Vehicle('one');
        $location = new Location('ici', 'ici', 51);

        Park::do($vehicle, $location);

        $this->expectException(\RuntimeException::class);
        Park::do($vehicle, $location);
    }
}
