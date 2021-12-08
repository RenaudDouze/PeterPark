<?php

declare(strict_types = 1);

namespace Tests\PHPUnit\Infra\Database\Transformer;

use \Domain\Entity\Location;
use \Infra\Database\Transformer\LocationTransformer;
use \PHPUnit\Framework\TestCase;
use \RedBeanPHP\R;

class LocationTransformerEntityToBeanTest extends TestCase
{
    public function testEntityToBeanNewOne() : void
    {
        $location = new Location('R', '42');

        $bean = LocationTransformer::entityToBean($location);

        $this->assertEquals('R', $bean->latitude);
        $this->assertEquals('42', $bean->longitude);
        $this->assertEquals(0, $bean->altitude);
        $this->assertEquals(0, $bean->id);
    }

    public function testEntityToBeanNewOneWithAltitude() : void
    {
        $location = new Location('R', '42', 1993.0526);

        $bean = LocationTransformer::entityToBean($location);

        $this->assertEquals('R', $bean->latitude);
        $this->assertEquals('42', $bean->longitude);
        $this->assertEquals(1993.0526, $bean->altitude);
        $this->assertEquals(0, $bean->id);
    }

    public function testEntityToBeanExistingOne() : void
    {
        $previousId = $this->createVehicleInDb();

        $location = new Location('R', '42');
        $location->setId($previousId);

        $bean = LocationTransformer::entityToBean($location);

        $this->assertEquals('R', $bean->latitude);
        $this->assertEquals('42', $bean->longitude);
        $this->assertEquals(0, $bean->altitude);
        $this->assertEquals($previousId, $bean->id);
    }

    public function testEntityToBeanExistingOneWithAltitude() : void
    {
        $previousId = $this->createVehicleInDb(1940);

        $location = new Location('R', '42', 42.42);
        $location->setId($previousId);

        $bean = LocationTransformer::entityToBean($location);

        $this->assertEquals('R', $bean->latitude);
        $this->assertEquals('42', $bean->longitude);
        $this->assertEquals(42.42, $bean->altitude);
        $this->assertEquals($previousId, $bean->id);
    }

    private function createVehicleInDb(?float $altitude = null) : int
    {
        $bean = R::dispense(Location::BEAN_NAME);
        $bean->latitude = 'Somewhere';
        $bean->longitude = 'over the rainbow';

        if ($altitude !== null) {
            $bean->altitude = $altitude;
        }

        return (int) R::store($bean);
    }
}
