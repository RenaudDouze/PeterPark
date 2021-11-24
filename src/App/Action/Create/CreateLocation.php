<?php

declare(strict_types = 1);

namespace App\Action\Create;

use \Domain\Entity\Location;

class CreateLocation
{
    public static function do(string $longitude, string $latitude) : Location
    {
        return new Location($longitude, $latitude);
    }
}
