<?php

declare(strict_types = 1);

namespace Tests\PHPUnit\Infra\Database\Transformer;

use \Domain\Entity\Location;
use \Domain\Entity\Vehicle;
use \Infra\Database\Transformer\VehicleTransformer;
use \PHPUnit\Framework\TestCase;
use \RedBeanPHP\R;

class VehicleTransformerEntityToBeanTest extends TestCase
{
    public function testEntityToBeanNewOneWithoutLocation() : void
    {
        $vehicle = new Vehicle("ALLEZ L'OM");

        $bean = VehicleTransformer::entityToBean($vehicle);

        $this->assertEquals("ALLEZ L'OM", $bean->plateNumber);
        $this->assertNull($bean->location);
        $this->assertEquals(0, $bean->id);
    }

    public function testEntityToBeanNewOneWithLocation() : void
    {
        $vehicle = new Vehicle("ALLEZ L'OM");
        $location = new Location('Stade', 'Vélodrome');
        $vehicle->park($location);

        $bean = VehicleTransformer::entityToBean($vehicle);

        $this->assertEquals("ALLEZ L'OM", $bean->plateNumber);
        $this->assertEquals('Stade', $bean->location->latitude);
        $this->assertEquals('Vélodrome', $bean->location->longitude);
        $this->assertEquals(0, $bean->location->altitude);
        $this->assertEquals(0, $bean->id);
    }

    public function testEntityToBeanNewOneWithLocationAndAltitude() : void
    {
        $vehicle = new Vehicle("ALLEZ L'OM");
        $location = new Location('Stade', 'Vélodrome', 1937.0613);
        $vehicle->park($location);

        $bean = VehicleTransformer::entityToBean($vehicle);

        $this->assertEquals("ALLEZ L'OM", $bean->plateNumber);
        $this->assertEquals('Stade', $bean->location->latitude);
        $this->assertEquals('Vélodrome', $bean->location->longitude);
        $this->assertEquals(1937.0613, $bean->location->altitude);
        $this->assertEquals(0, $bean->id);
    }

    public function testEntityToBeanExistingOneWithoutLocation() : void
    {
        $previousId = $this->createVehicleInDb();

        $vehicle = new Vehicle("ALLEZ L'OM");
        $vehicle->setId($previousId);

        $bean = VehicleTransformer::entityToBean($vehicle);

        $this->assertEquals("ALLEZ L'OM", $bean->plateNumber);
        $this->assertNull($bean->location);
        $this->assertEquals($previousId, $bean->id);
    }

    public function testEntityToBeanExistingOneWithLocation() : void
    {
        $previousId = $this->createVehicleWithLocationInDb();

        $vehicle = new Vehicle("ALLEZ L'OM");
        $vehicle->setId($previousId);

        $bean = VehicleTransformer::entityToBean($vehicle);

        $this->assertEquals("ALLEZ L'OM", $vehicle->getPlateNumber());
        $this->assertEquals('Au fond', $bean->location->latitude);
        $this->assertEquals('des filets', $bean->location->longitude);
        $this->assertEquals(0, $bean->location->altitude);
        $this->assertEquals($previousId, $bean->id);
    }

    public function testEntityToBeanExistingOneWithLocationAndAltitude() : void
    {
        $previousId = $this->createVehicleWithLocationInDb(1935.0428);

        $vehicle = new Vehicle("ALLEZ L'OM");
        $vehicle->setId($previousId);

        $bean = VehicleTransformer::entityToBean($vehicle);

        $this->assertEquals("ALLEZ L'OM", $vehicle->getPlateNumber());
        $this->assertEquals('Au fond', $bean->location->latitude);
        $this->assertEquals('des filets', $bean->location->longitude);
        $this->assertEquals(1935.0428, $bean->location->altitude);
        $this->assertEquals($previousId, $bean->id);
    }

    private function createVehicleInDb() : int
    {
        $bean = R::dispense(Vehicle::BEAN_NAME);
        $bean->plateNumber = 'DROIT AU BUT';

        return (int) R::store($bean);
    }

    private function createVehicleWithLocationInDb(?float $altitude = null) : int
    {
        $locationBean = R::dispense(Location::BEAN_NAME);
        $locationBean->latitude = 'Au fond';
        $locationBean->longitude = 'des filets';

        if ($altitude !== null) {
            $locationBean->altitude = $altitude;
        }

        $vehicleBean = R::dispense(Vehicle::BEAN_NAME);
        $vehicleBean->plateNumber = 'DROIT AU BUT';
        $vehicleBean->location = $locationBean;

        return (int) R::store($vehicleBean);
    }
}
