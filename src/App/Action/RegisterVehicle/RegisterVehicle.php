<?php

namespace App\Action\RegisterVehicle;

use Domain\Entity\Vehicle;
use Domain\Entity\Fleet;
use Infra\Exception\AlreadyInFleetException;

class RegisterVehicle
{
    /**
     * @throws \RuntimeException
     */
    public static function do(Vehicle $vehicle, Fleet $fleet): Fleet
    {
        try {
            $fleet->add($vehicle);

            return $fleet;
        } catch (AlreadyInFleetException $e) {
            throw new \RuntimeException("Error while register the vehicle", 1, $e);
        }
    }
}
