<?php

declare(strict_types = 1);

namespace App\Action\RegisterVehicle;

use \Domain\Entity\Fleet;
use \Domain\Entity\Vehicle;

class IsRegistered
{
    public static function check(Vehicle $vehicle, Fleet $fleet) : bool
    {
        return $fleet->isIn($vehicle);
    }
}
