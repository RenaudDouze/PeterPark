<?php

declare(strict_types = 1);

namespace Tests\PHPUnit\Infra\Database\Transformer;

use \Domain\Entity\Location;
use \Infra\Database\Transformer\LocationTransformer;
use \PHPUnit\Framework\TestCase;
use \RedBeanPHP\R;

class LocationTransformerBeanToEntityTest extends TestCase
{
    public function testBeanToEntityNewOne() : void
    {
        $bean = R::dispense(Location::BEAN_NAME);
        $bean->latitude = 'lat';
        $bean->longitude = 'lon';

        $location = LocationTransformer::beanToEntity($bean);

        $this->assertEquals('lat', $location->getLatitude());
        $this->assertEquals('lon', $location->getLongitude());
        $this->assertEquals(0, $location->getAltitude());
        $this->assertEquals(0, $location->getId());
    }

    public function testBeanToEntityNewOneWithAltitude() : void
    {
        $bean = R::dispense(Location::BEAN_NAME);
        $bean->latitude = 'lat';
        $bean->longitude = 'lon';
        $bean->altitude = 0.1;

        $location = LocationTransformer::beanToEntity($bean);

        $this->assertEquals('lat', $location->getLatitude());
        $this->assertEquals('lon', $location->getLongitude());
        $this->assertEquals(0.1, $location->getAltitude());
        $this->assertEquals(0, $location->getId());
    }

    public function testBeanToEntityExistingOne() : void
    {
        $bean = R::dispense(Location::BEAN_NAME);
        $bean->latitude = 'lat';
        $bean->longitude = 'lon';
        $id = R::store($bean);
        $loadedBean = R::load(Location::BEAN_NAME, $id);

        $location = LocationTransformer::beanToEntity($loadedBean);

        $this->assertEquals('lat', $location->getLatitude());
        $this->assertEquals('lon', $location->getLongitude());
        $this->assertEquals(0, $location->getAltitude());
        $this->assertEquals($id, $location->getId());
    }

    public function testBeanToEntityExistingOneWithAltitude() : void
    {
        $bean = R::dispense(Location::BEAN_NAME);
        $bean->latitude = 'lat';
        $bean->longitude = 'lon';
        $bean->altitude = 9.9;
        $id = R::store($bean);
        $loadedBean = R::load(Location::BEAN_NAME, $id);

        $location = LocationTransformer::beanToEntity($loadedBean);

        $this->assertEquals('lat', $location->getLatitude());
        $this->assertEquals('lon', $location->getLongitude());
        $this->assertEquals(9.9, $location->getAltitude());
        $this->assertEquals($id, $location->getId());
    }
}
