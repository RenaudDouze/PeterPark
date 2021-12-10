<?php

declare(strict_types = 1);

namespace Tests\PHPUnit\Infra\Database\Transformer;

use \Domain\Entity\Location;
use \Domain\Entity\Vehicle;
use \Infra\Database\Transformer\VehicleTransformer;
use \PHPUnit\Framework\TestCase;
use \RedBeanPHP\R;

class VehicleTransformerBeanToEntityTest extends TestCase
{
    public function testBeanToEntityNewOneWithoutLocation() : void
    {
        $bean = R::dispense(Vehicle::BEAN_NAME);
        $bean->plateNumber = 'plate';

        $vehicle = VehicleTransformer::beanToEntity($bean);

        $this->assertEquals('plate', $vehicle->getPlateNumber());
        $this->assertNull($vehicle->whereIs());
        $this->assertEquals(0, $vehicle->getId());
    }

    public function testBeanToEntityNewOneWithLocation() : void
    {
        $locationBean = R::dispense(Location::BEAN_NAME);
        $locationBean->latitude = 'quelque';
        $locationBean->longitude = 'part';
        $bean = R::dispense(Vehicle::BEAN_NAME);
        $bean->plateNumber = 'plate';
        $bean->location = $locationBean;

        $vehicle = VehicleTransformer::beanToEntity($bean);

        $this->assertEquals('plate', $vehicle->getPlateNumber());
        $this->assertEquals('quelque', $vehicle->whereIs()->getLatitude());
        $this->assertEquals('part', $vehicle->whereIs()->getLongitude());
        $this->assertEquals(0, $vehicle->whereIs()->getAltitude());
        $this->assertEquals(0, $vehicle->getId());
    }

    public function testBeanToEntityNewOneWithLocationAndAltitude() : void
    {
        $locationBean = R::dispense(Location::BEAN_NAME);
        $locationBean->latitude = 'quelque';
        $locationBean->longitude = 'part';
        $locationBean->altitude = 4587.4;
        $bean = R::dispense(Vehicle::BEAN_NAME);
        $bean->plateNumber = 'plate';
        $bean->location = $locationBean;

        $vehicle = VehicleTransformer::beanToEntity($bean);

        $this->assertEquals('plate', $vehicle->getPlateNumber());
        $this->assertEquals('quelque', $vehicle->whereIs()->getLatitude());
        $this->assertEquals('part', $vehicle->whereIs()->getLongitude());
        $this->assertEquals(4587.4, $vehicle->whereIs()->getAltitude());
        $this->assertEquals(0, $vehicle->getId());
    }

    public function testBeanToEntityExistingOneWithoutLocation() : void
    {
        $bean = R::dispense(Vehicle::BEAN_NAME);
        $bean->plateNumber = 'plate';
        $id = R::store($bean);
        $loadedBean = R::load(Vehicle::BEAN_NAME, $id);

        $vehicle = VehicleTransformer::beanToEntity($loadedBean);

        $this->assertEquals('plate', $vehicle->getPlateNumber());
        $this->assertNull($vehicle->whereIs());
        $this->assertEquals($id, $vehicle->getId());
    }

    public function testBeanToEntityExistingOneWithLocation() : void
    {
        $locationBean = R::dispense(Location::BEAN_NAME);
        $locationBean->latitude = 'quelque';
        $locationBean->longitude = 'part';
        $bean = R::dispense(Vehicle::BEAN_NAME);
        $bean->plateNumber = 'plate';
        $bean->location = $locationBean;
        $id = R::store($bean);
        \var_dump($id);
        $loadedBean = R::load(Vehicle::BEAN_NAME, $id);

        $vehicle = VehicleTransformer::beanToEntity($loadedBean);

        $this->assertEquals('plate', $vehicle->getPlateNumber());
        $this->assertEquals('quelque', $vehicle->whereIs()->getLatitude());
        $this->assertEquals('part', $vehicle->whereIs()->getLongitude());
        $this->assertEquals(0, $vehicle->whereIs()->getAltitude());
        $this->assertEquals($id, $vehicle->getId());
    }

    public function testBeanToEntityExistingOneWithLocationAndAltitude() : void
    {
        $locationBean = R::dispense(Location::BEAN_NAME);
        $locationBean->latitude = 'quelque';
        $locationBean->longitude = 'part';
        $locationBean->altitude = 787.4;
        $bean = R::dispense(Vehicle::BEAN_NAME);
        $bean->plateNumber = 'plate';
        $bean->location = $locationBean;
        $id = R::store($bean);
        \var_dump($id);
        $loadedBean = R::load(Vehicle::BEAN_NAME, $id);

        $vehicle = VehicleTransformer::beanToEntity($loadedBean);

        $this->assertEquals('plate', $vehicle->getPlateNumber());
        $this->assertEquals('quelque', $vehicle->whereIs()->getLatitude());
        $this->assertEquals('part', $vehicle->whereIs()->getLongitude());
        $this->assertEquals(787.4, $vehicle->whereIs()->getAltitude());
        $this->assertEquals($id, $vehicle->getId());
    }
}
