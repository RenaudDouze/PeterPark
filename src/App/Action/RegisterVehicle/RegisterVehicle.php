<?php

namespace App\Action\RegisterVehicle;

use Domain\Entity\Vehicle;
use Domain\Entity\Fleet;
use Infra\Exception\AlreadyInFleetException;

class RegisterVehicle
{
	public static function do(Vehicle $vehicle, Fleet $fleet): Fleet
	{
		try {
			$fleet->add($vehicle);
		} catch (AlreadyInFleetException $e) {
			throw new Exception("Error while register the vehicle", 1, $e);
		}
	}
}