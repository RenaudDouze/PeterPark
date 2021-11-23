<?php

namespace App\Action\Create;

use Domain\Entity\Location;

class Location
{
	public static function do(string $longitude, string $latitude): Location
	{
		return new Location($longitude, $latitude);
	}
}