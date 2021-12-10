<?php

declare(strict_types = 1);

namespace Tests\PHPUnit\Domain\Entity;

use \Domain\Entity\Fleet;
use \Domain\Entity\Vehicle;
use \Infra\Database\Transformer\FleetTransformer;
use \PHPUnit\Framework\TestCase;
use \RedBeanPHP\OODBBean;
use \RedBeanPHP\R;

class FleetTest extends TestCase
{
    public function testOwner() : void
    {
        $amiralFleet = new Fleet('Amiral');

        $this->assertEquals('Amiral', $amiralFleet->getOwnerId());
    }

    public function testAdd() : void
    {
        $vehicleOne = new Vehicle('one');
        $vehicleTwo = new Vehicle('two');

        $fleet = new Fleet('John Doeuf');

        $this->assertEquals(1, $fleet->add($vehicleOne));
        $this->assertEquals(2, $fleet->add($vehicleTwo));
    }

    public function testAddTwice() : void
    {
        $vehicleOne = new Vehicle('one');
        $vehicleTwo = new Vehicle('two');

        $fleet = new Fleet('John Café');

        $this->assertEquals(1, $fleet->add($vehicleOne));
        $this->assertEquals(2, $fleet->add($vehicleTwo));

        $this->expectException(\Infra\Exception\AlreadyInFleet::class);
        $fleet->add($vehicleTwo);
    }

    public function testAddSame() : void
    {
        $vehicleOne = new Vehicle('one');
        $vehicleOneSame = new Vehicle('one');

        $fleet = new Fleet('Joe Bar');

        $this->assertEquals(1, $fleet->add($vehicleOne));

        $this->expectException(\Infra\Exception\AlreadyInFleet::class);
        $this->assertEquals(2, $fleet->add($vehicleOneSame));
    }

    public function testIsIn() : void
    {
        $vehicleOne = new Vehicle('one');
        $vehicleTwo = new Vehicle('two');

        $fleet = new Fleet('Joe Joe');

        $fleet->add($vehicleOne);

        $this->assertTrue($fleet->isIn($vehicleOne));
        $this->assertFalse($fleet->isIn($vehicleTwo));
    }

    public function testCreateFromBean() : void
    {
        $beanFleet = R::dispense('fleet', 1, false);

        $beanFleet->ownerId = 'CarTreiz';

        $fleet = FleetTransformer::beanToEntity($beanFleet);

        $this->assertEquals('CarTreiz', $fleet->getOwnerId());
    }

    public function testCreateFromBeanWithVehicles() : void
    {
        $beanVehicleOne = R::dispense('vehicle', 1, false);
        $beanVehicleOne->plateNumber = 'Aix-Marseille';
        $beanVehicleTwo = R::dispense('vehicle', 1, false);
        $beanVehicleTwo->plateNumber = 'Marseille-Marignane';

        $beanFleet = R::dispense('fleet', 1, false);

        $beanFleet->ownerId = 'CarTreiz';
        $beanFleet->ownVehicleList = [
            $beanVehicleOne,
            $beanVehicleTwo,
        ];

        if (! ($beanFleet instanceof OODBBean)) {
            throw new \RuntimeException();
        }

        $fleet = FleetTransformer::beanToEntity($beanFleet);

        $this->assertEquals('CarTreiz', $fleet->getOwnerId());
        $this->assertCount(2, $fleet->getVehicles());
        $this->assertEquals('Aix-Marseille', $fleet->getVehicles()[0]->getPlateNumber());
        $this->assertEquals('Marseille-Marignane', $fleet->getVehicles()[1]->getPlateNumber());
    }
}
