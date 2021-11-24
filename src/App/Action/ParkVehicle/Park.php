<?php

declare(strict_types = 1);

namespace App\Action\ParkVehicle;

use \Domain\Entity\Location;
use \Domain\Entity\Vehicle;
use \Infra\Exception\AlreadyParkedHere;

class Park
{
    public static function do(Vehicle $vehicle, Location $location) : void
    {
        try {
            $vehicle->park($location);
        } catch (AlreadyParkedHere $e) {
            throw new \RuntimeException('Error while parking the vehicle', 1, $e);
        }
    }
}
