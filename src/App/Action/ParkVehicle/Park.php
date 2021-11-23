<?php

namespace App\Action\ParkVehicle

use Domain\Entity\Vehicle;
use Domain\Entity\Fleet;
use Infra\Exception\AlreadyInFleetException;

class Park
{
	public static function do(Vehicle $vehicle, Location $location): void
	{
		try {
			$vehicle->park($location);
		} catch (AlreadyParkedHereException $e) {
			throw new Exception("Error while parking the vehicle", 1, $e);
			
		}
	}
}