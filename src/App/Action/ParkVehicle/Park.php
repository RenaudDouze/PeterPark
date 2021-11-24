<?php

namespace App\Action\ParkVehicle;

use Domain\Entity\Location;
use Domain\Entity\Vehicle;
use Infra\Exception\AlreadyParkedHereException;

class Park
{
    public static function do(Vehicle $vehicle, Location $location): void
    {
        try {
            $vehicle->park($location);
        } catch (AlreadyParkedHereException $e) {
            throw new \RuntimeException("Error while parking the vehicle", 1, $e);

        }
    }
}
