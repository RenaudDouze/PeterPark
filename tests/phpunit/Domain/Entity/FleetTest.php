<?php

declare(strict_types = 1);

namespace Tests\PHPUnit\Domain\Entity;

use \Domain\Entity\Fleet;
use \Domain\Entity\Vehicle;
use \PHPUnit\Framework\TestCase;

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
}
