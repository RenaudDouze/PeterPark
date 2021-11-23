<?php

namespace App\Action\RegisterVehicle;

use Domain\Entity\Vehicle;
use Domain\Entity\Fleet;

class IsRegistered
{
	public static function check(Vehicle $vehicle, Fleet $fleet): bool
	{
		return $fleet->isIn($vehicle);
	}
}