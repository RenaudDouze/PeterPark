<?php

namespace Tests\PHPUnit\Action\RegisterVehicle;

use App\Action\RegisterVehicle\IsRegistered;
use Domain\Entity\Fleet;
use Domain\Entity\Vehicle;
use PHPUnit\Framework\TestCase;

class TestIsRegistered extends TestCase
{
    public function testCheck()
    {
        $vehicle = new Vehicle();
        $fleet = new Fleet();

        $this->assertFlase(IsRegistered::check($vehicle, $fleet));

        $fleet->add($vehicle);

        $this->assertTrue(IsRegistered::check($vehicle, $fleet));
    }
}
