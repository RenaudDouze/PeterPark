<?php

declare(strict_types = 1);

namespace Tests\PHPUnit\App\Action\Save;

use \App\Action\Save\SaveVehicle;
use \Domain\Entity\Location;
use \Domain\Entity\Vehicle;
use \PHPUnit\Framework\TestCase;
use \RedBeanPHP\R;
use \Tests\Tools\Infra\Database\Db;

class SaveVehicleTest extends TestCase
{
    public function testDo() : void
    {
        $vehicle = new Vehicle('ECTO 1');

        $id = SaveVehicle::do($vehicle);

        $this->assertIsInt($id);

        $dbVehicle = R::load('vehicle', $id);

        $this->assertEquals($vehicle->getPlateNumber(), $dbVehicle->plateNumber);
        $this->assertEquals($vehicle->whereIs(), $dbVehicle->location);
    }

    public function testDoWithLocation() : void
    {
        $vehicle = new Vehicle('OUTATIME');
        $location = new Location('10/26', '1985');
        $vehicle->park($location);

        $id = SaveVehicle::do($vehicle);

        $this->assertIsInt($id);

        $dbVehicle = R::load('vehicle', $id);

        $this->assertEquals('OUTATIME', $dbVehicle->plateNumber);
        $this->assertEquals('10/26', $dbVehicle->location->latitude);
        $this->assertEquals('1985', $dbVehicle->location->longitude);
        $this->assertEquals(0, $dbVehicle->location->altitude);
    }

    public function testDoWithLocationAndAltitude() : void
    {
        $vehicle = new Vehicle('OUTATIME');
        $location = new Location('10/26', '1985', 123);
        $vehicle->park($location);

        $id = SaveVehicle::do($vehicle);

        $this->assertIsInt($id);

        $dbVehicle = R::load('vehicle', $id);

        $this->assertEquals('OUTATIME', $dbVehicle->plateNumber);
        $this->assertEquals('10/26', $dbVehicle->location->latitude);
        $this->assertEquals('1985', $dbVehicle->location->longitude);
        $this->assertEquals(123, $dbVehicle->location->altitude);
    }

    /**
     * @before
     */
    public function setUp() : void
    {
        Db::connect();
    }

    /**
     * @after
     */
    public function tearDown() : void
    {
        R::close();
    }
}
