<?php

declare(strict_types = 1);

namespace Tests\PHPUnit\Action\Create;

use \App\Action\Create\CreateVehicle;
use \Domain\Entity\Vehicle;
use \PHPUnit\Framework\TestCase;

class CreateVehicleTest extends TestCase
{
    public function testDo() : void
    {
        $this->assertInstanceOf(Vehicle::class, CreateVehicle::do('one'));
    }
}
