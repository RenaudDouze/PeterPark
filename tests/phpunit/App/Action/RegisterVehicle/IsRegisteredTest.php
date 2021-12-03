<?php

declare(strict_types = 1);

namespace Tests\PHPUnit\Action\RegisterVehicle;

use \App\Action\RegisterVehicle\IsRegistered;
use \Domain\Entity\Fleet;
use \Domain\Entity\Vehicle;
use \PHPUnit\Framework\TestCase;

class IsRegisteredTest extends TestCase
{
    public function testCheck() : void
    {
        $vehicle = new Vehicle('one');
        $fleet = new Fleet("Joe l'asticot");

        $this->assertFalse(IsRegistered::check($vehicle, $fleet));

        $fleet->add($vehicle);

        $this->assertTrue(IsRegistered::check($vehicle, $fleet));
    }
}
