<?php

declare(strict_types = 1);

namespace Tests\PHPUnit\App\Action\Save;

use \App\Action\Save\SaveFleet;
use \Domain\Entity\Fleet;
use \PHPUnit\Framework\TestCase;
use \RedBeanPHP\R;
use \Tests\Tools\Infra\Database\Db;

class SaveFleetTest extends TestCase
{
    public function testDo() : void
    {
        $fleet = new Fleet('Capitaine Kirk');

        $id = SaveFleet::do($fleet);

        $this->assertIsInt($id);

        $dbFleet = R::load('fleet', $id);

        $this->assertEquals($fleet->getOwnerId(), $dbFleet->ownerId);

        $fleetVehicles = $fleet->getVehicles();
        $i = 0;

        foreach ($dbFleet->ownVehiclesList as $dbVehicle) {
            $this->assertEquals($fleetVehicles[$i]->getPlateNumber(), $dbVehicle->plateNumber);
            $this->assertEquals($fleetVehicles[$i]->whereIs(), $dbVehicle->location);

            $i++;
        }

        $this->assertCount($i, $fleetVehicles);
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
        Db::disconnect();
    }
}
