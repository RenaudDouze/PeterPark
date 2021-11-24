<?php

declare(strict_types = 1);

namespace App\Action\RegisterVehicle;

use \Domain\Entity\Fleet;
use \Domain\Entity\Vehicle;
use \Infra\Exception\AlreadyInFleet;

class RegisterVehicle
{
    public static function do(Vehicle $vehicle, Fleet $fleet) : Fleet
    {
        try {
            $fleet->add($vehicle);

            return $fleet;
        } catch (AlreadyInFleet $e) {
            throw new \RuntimeException('Error while register the vehicle', 1, $e);
        }
    }
}
