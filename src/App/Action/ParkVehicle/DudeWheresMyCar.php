<?php

namespace App\Action\ParkVehicle;

use Domain\Entity\Location;
use Domain\Entity\Vehicle;

class DudeWheresMyCar
{
    public static function get(Vehicle $vehicle): ?Location
    {
        return $vehicle->whereIs();
    }
}
