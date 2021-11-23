<?php

namespace App\Action\ParkVehicle;

use Domain\Entity\Vehicle;
use Domain\Entity\Fleet;
use Infra\Exception\AlreadyInFleetException;

class DudeWheresMyCar
{
	public static function get(Vehicle $vehicle): Location
	{
		return $vehicle->whereIs();
	}
}