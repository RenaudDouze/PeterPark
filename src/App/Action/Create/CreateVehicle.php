<?php

declare(strict_types = 1);

namespace App\Action\Create;

use \Domain\Entity\Vehicle;

class CreateVehicle
{
    public static function do(string $plateNumber) : Vehicle
    {
        return new Vehicle($plateNumber);
    }
}
