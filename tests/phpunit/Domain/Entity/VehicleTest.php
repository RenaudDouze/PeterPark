<?php

declare(strict_types = 1);

namespace Tests\PHPUnit\Domain\Entity;

use \Domain\Entity\Location;
use \Domain\Entity\Vehicle;
use \Infra\Database\Transformer\VehicleTransformer;
use \PHPUnit\Framework\TestCase;
use \RedBeanPHP\OODBBean;
use \RedBeanPHP\R;

class VehicleTest extends TestCase
{
    public function testConstructor() : void
    {
        $vehicleOne = new Vehicle('one');
        $vehicleTwo = new Vehicle('two');
        $vehicleOneSame = new Vehicle('one');

        $this->assertEquals($vehicleOne, $vehicleOneSame);
        $this->assertNotSame($vehicleOne, $vehicleTwo);
    }

    public function testWhereIs() : void
    {
        $vehicle = new Vehicle('one');

        $this->assertNull($vehicle->whereIs());

        $location = new Location('D', '12');
        $vehicle->park($location);

        $this->assertEquals($location, $vehicle->whereIs());
        $this->assertEquals('D', $vehicle->whereIs()->getLatitude());
        $this->assertEquals('12', $vehicle->whereIs()->getLongitude());
        $this->assertEquals(0, $vehicle->whereIs()->getAltitude());
    }

    public function testWhereIsWithAltitude() : void
    {
        $vehicle = new Vehicle('one');

        $this->assertNull($vehicle->whereIs());

        $location = new Location('D', '12', 45.45);
        $vehicle->park($location);

        $this->assertEquals($location, $vehicle->whereIs());
        $this->assertEquals('D', $vehicle->whereIs()->getLatitude());
        $this->assertEquals('12', $vehicle->whereIs()->getLongitude());
        $this->assertEquals(45.45, $vehicle->whereIs()->getAltitude());
    }

    public function testPark() : void
    {
        $vehicle = new Vehicle('one');
        $locationD12 = new Location('D', '12');
        $locationE1 = new Location('E', '1');

        $vehicle->park($locationD12);
        $vehicle->park($locationE1);

        $this->expectException(\Infra\Exception\AlreadyParkedHere::class);
        $vehicle->park($locationE1);
    }

    public function testParkWithAltitude() : void
    {
        $vehicle = new Vehicle('one');
        $locationD12 = new Location('D', '12', 19.86);
        $locationE1 = new Location('E', '1', 19.84);

        $vehicle->park($locationD12);
        $vehicle->park($locationE1);

        $this->expectException(\Infra\Exception\AlreadyParkedHere::class);
        $vehicle->park($locationE1);
    }

    public function testCreateFromBean() : void
    {
        $beanVehicle = R::dispense('vehicle', 1, false);
        \assert($beanVehicle instanceof OODBBean);

        $beanVehicle->plateNumber = '12 DOUZ 12';

        $vehicle = VehicleTransformer::beanToEntity($beanVehicle);

        $this->assertEquals('12 DOUZ 12', $vehicle->getPlateNumber());
    }

    public function testCreateFromBeanWithLocation() : void
    {
        $beanLocation = R::dispense('location', 1, false);

        $beanLocation->latitude = 'plus haut';
        $beanLocation->longitude = 'un peu plus à gauche';

        $beanVehicle = R::dispense('vehicle', 1, false);

        $beanVehicle->plateNumber = '12 DOUZ 12';
        $beanVehicle->location = $beanLocation;

        if (! ($beanVehicle instanceof OODBBean)) {
            throw new \RuntimeException();
        }

        $vehicle = VehicleTransformer::beanToEntity($beanVehicle);

        $this->assertEquals('12 DOUZ 12', $vehicle->getPlateNumber());
        $this->assertEquals('plus haut', $vehicle->whereIs()->getLatitude());
        $this->assertEquals('un peu plus à gauche', $vehicle->whereIs()->getLongitude());
    }

    public function testCreateFromBeanWithLocationAndAltitude() : void
    {
        $beanLocation = R::dispense('location', 1, false);

        $beanLocation->latitude = 'plus haut';
        $beanLocation->longitude = 'un peu plus à gauche';
        $beanLocation->altitude = 1998.0712;

        $beanVehicle = R::dispense('vehicle', 1, false);

        $beanVehicle->plateNumber = '12 DOUZ 12';
        $beanVehicle->location = $beanLocation;

        if (! ($beanVehicle instanceof OODBBean)) {
            throw new \RuntimeException();
        }

        $vehicle = VehicleTransformer::beanToEntity($beanVehicle);

        $this->assertEquals('12 DOUZ 12', $vehicle->getPlateNumber());
        $this->assertEquals('plus haut', $vehicle->whereIs()->getLatitude());
        $this->assertEquals('un peu plus à gauche', $vehicle->whereIs()->getLongitude());
        $this->assertEquals(1998.0712, $vehicle->whereIs()->getAltitude());
    }
}
