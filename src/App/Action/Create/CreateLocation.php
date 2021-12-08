<?php

declare(strict_types = 1);

namespace App\Action\Create;

use \Domain\Entity\Location;

class CreateLocation
{
    public static function do(string $latitude, string $longitude, ?float $altitude = null) : Location
    {
        return new Location($latitude, $longitude, $altitude
            ?? 0);
    }
}
