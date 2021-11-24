<?php

namespace Tests\PHPUnit\Action\RegisterVehicle;

use App\Action\RegisterVehicle\RegisterVehicle;
use Domain\Entity\Fleet;
use Domain\Entity\Vehicle;
use PHPUnit\Framework\TestCase;

class TestRegisterVehicle extends TestCase
{
    public function testDo()
    {
        $vehicle = new Vehicle();
        $fleet = new Fleet();
        
        $this->assertFalse($fleet->isIn($vehicle));
        
        $this->assertSame($fleet, RegisterVehicle::do($vehicle, $fleet));

        $this->assertTrue($fleet->isIn($vehicle));
    }

    public function testDoException()
    {
        $vehicle = new Vehicle();
        $fleet = new Fleet();

        $this->assertSame($fleet, RegisterVehicle::do($vehicle, $fleet));

        $this->expectException(\RuntimeException::class);
        $this->assertSame($fleet, RegisterVehicle::do($vehicle, $fleet));
    }
}

