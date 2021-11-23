<?php

namespace App\Action\Create;

use Domain\Entity\Vehicle;

class Vehicle
{
	public static function do(): Vehicle
	{
		return new Vehicle();
	}
}