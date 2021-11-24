<?php

namespace Tests\PHPUnit\Action\Create;

use App\Action\Create\CreateVehicle;
use Domain\Entity\Vehicle;
use PHPUnit\Framework\TestCase;

class CreateVehicleTest extends TestCase
{
    public function testDo()
    {
        $this->assertInstanceOf(Vehicle::class, CreateVehicle::do());
    }
}
