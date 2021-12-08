<?php

declare(strict_types = 1);

namespace Tests\PHPUnit\Infra\DTO;

use \Domain\Entity\Fleet;
use \Domain\Entity\Vehicle;
use \Infra\Database\Transformer\FleetTransformer;
use \Infra\Database\Transformer\VehicleTransformer;
use \PHPUnit\Framework\TestCase;
use \RedBeanPHP\R;

class FleetTransformerEntityToBeanTest extends TestCase
{
    public function testEntityToBeanNewOneWithoutVehicles() : void
    {
        $fleet = new Fleet('Han Solo');

        $bean = FleetTransformer::entityToBean($fleet);

        $this->assertEquals('Han Solo', $bean->ownerId);
        $this->assertEquals([], $bean->ownVehicleList);
        $this->assertEquals(0, $bean->id);
    }

    public function testEntityToBeanNewOneWithVehicles() : void
    {
        $vehicleOne = new Vehicle('Millennium Falcon');
        $vehicleTwo = new Vehicle('A-Wing');

        $fleet = new Fleet('Han Solo');
        $fleet->add($vehicleOne);
        $fleet->add($vehicleTwo);

        $bean = FleetTransformer::entityToBean($fleet);
        $vehicleOneBean = VehicleTransformer::entityToBean($vehicleOne);
        $vehicleTwoBean = VehicleTransformer::entityToBean($vehicleTwo);

        $this->assertEquals('Han Solo', $bean->ownerId);
        $this->assertCount(2, $bean->ownVehicleList);
        $this->assertEquals([$vehicleOneBean, $vehicleTwoBean], $bean->ownVehicleList);
        $this->assertEquals(0, $bean->id);
    }

    public function testEntityToBeanExistingOneWithoutVehicles() : void
    {
        $previousId = $this->createFleetInDb();

        $fleet = new Fleet('Luke Skywalker');
        $fleet->setId($previousId);

        $bean = FleetTransformer::entityToBean($fleet);

        $this->assertEquals('Luke Skywalker', $bean->ownerId);
        $this->assertEquals([], $bean->ownVehicleList);
        $this->assertEquals($previousId, $bean->id);
    }

    public function testEntityToBeanExistingOneWithVehicles() : void
    {
        $previousId = $this->createFleetWithVehiclesInDb();

        $fleet = new Fleet('Rey #NoSpoiler');
        $fleet->setId($previousId);

        $bean = FleetTransformer::entityToBean($fleet);

        $this->assertEquals('Rey #NoSpoiler', $bean->ownerId);
        $this->assertCount(1, $bean->ownVehicleList);
        $firstVehicle = \reset($bean->ownVehicleList);
        $this->assertEquals('X-Wing', $firstVehicle->plateNumber);
        $this->assertEquals($previousId, $bean->id);
    }

    private function createFleetInDb() : int
    {
        $bean = R::dispense(Fleet::BEAN_NAME);
        $bean->ownerId = 'Luke Skywalker';

        return (int) R::store($bean);
    }

    private function createFleetWithVehiclesInDb() : int
    {
        $vehicleBean = R::dispense(Vehicle::BEAN_NAME);
        $vehicleBean->plateNumber = 'X-Wing';

        $fleetBean = R::dispense(Fleet::BEAN_NAME);
        $fleetBean->ownerId = 'Luke Skywalker';
        $fleetBean->ownVehicleList[] = $vehicleBean;

        return (int) R::store($fleetBean);
    }
}
