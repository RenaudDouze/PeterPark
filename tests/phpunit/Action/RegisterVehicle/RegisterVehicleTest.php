<?php

declare(strict_types = 1);

namespace Tests\PHPUnit\Action\RegisterVehicle;

use \App\Action\RegisterVehicle\RegisterVehicle;
use \Domain\Entity\Fleet;
use \Domain\Entity\Vehicle;
use \PHPUnit\Framework\TestCase;

class RegisterVehicleTest extends TestCase
{
    public function testDo() : void
    {
        $vehicle = new Vehicle();
        $fleet = new Fleet();

        $this->assertFalse($fleet->isIn($vehicle));

        $this->assertSame($fleet, RegisterVehicle::do($vehicle, $fleet));

        $this->assertTrue($fleet->isIn($vehicle));
    }

    public function testDoException() : void
    {
        $vehicle = new Vehicle();
        $fleet = new Fleet();

        $this->assertSame($fleet, RegisterVehicle::do($vehicle, $fleet));

        $this->expectException(\RuntimeException::class);
        $this->assertSame($fleet, RegisterVehicle::do($vehicle, $fleet));
    }
}
