<?php

declare(strict_types = 1);

namespace Tests\PHPUnit\Infra\Database\Transformer;

use \Domain\Entity\Fleet;
use \Domain\Entity\Vehicle;
use \Infra\Database\Transformer\FleetTransformer;
use \PHPUnit\Framework\TestCase;
use \RedBeanPHP\R;

class FleetTransformerBeanToEntityTest extends TestCase
{
    public function testBeanToEntityNewOneWithoutVehicles() : void
    {
        $bean = R::dispense(Fleet::BEAN_NAME);
        $bean->ownerId = 'Oui Oui';

        $fleet = FleetTransformer::beanToEntity($bean);

        $this->assertEquals('Oui Oui', $fleet->getOwnerId());
        $this->assertEquals([], $fleet->getVehicles());
        $this->assertEquals(0, $fleet->getId());
    }

    public function testBeanToEntityNewOneWithVehicles() : void
    {
        $vehicleBean = R::dispense(Vehicle::BEAN_NAME);
        $vehicleBean->plateNumber = 'Taxi Jaune';
        $bean = R::dispense(Fleet::BEAN_NAME);
        $bean->ownerId = 'Oui Oui';
        $bean->ownVehicleList = [$vehicleBean];

        $fleet = FleetTransformer::beanToEntity($bean);

        $this->assertEquals('Oui Oui', $fleet->getOwnerId());
        $this->assertCount(1, $fleet->getVehicles());
        $this->assertEquals('Taxi Jaune', $fleet->getVehicles()[0]->getPlateNumber());
        $this->assertEquals(0, $fleet->getId());
    }

    public function testBeanToEntityExistingOneWithoutVehicles() : void
    {
        $bean = R::dispense(Fleet::BEAN_NAME);
        $bean->ownerId = 'Oui Oui';
        $id = R::store($bean);
        $loadedBean = R::load(Fleet::BEAN_NAME, $id);

        $fleet = FleetTransformer::beanToEntity($loadedBean);

        $this->assertEquals('Oui Oui', $fleet->getOwnerId());
        $this->assertEquals([], $fleet->getVehicles());
        $this->assertEquals($id, $fleet->getId());
    }

    public function testBeanToEntityExistingOneWithVehicles() : void
    {
        $vehicleBean = R::dispense(Vehicle::BEAN_NAME);
        $vehicleBean->plateNumber = 'Taxi Jaune';
        $bean = R::dispense(Fleet::BEAN_NAME);
        $bean->ownerId = 'Oui Oui';
        $bean->ownVehicleList = [$vehicleBean];
        $id = R::store($bean);
        $loadedBean = R::load(Fleet::BEAN_NAME, $id);

        $fleet = FleetTransformer::beanToEntity($loadedBean);

        $this->assertEquals('Oui Oui', $fleet->getOwnerId());
        $this->assertCount(1, $fleet->getVehicles());
        $this->assertEquals('Taxi Jaune', $fleet->getVehicles()[0]->getPlateNumber());
        $this->assertEquals($id, $fleet->getId());
    }
}
