<?php

namespace App\Action\Create;

use Domain\Entity\Vehicle;

class CreateVehicle
{
    public static function do(): Vehicle
    {
        return new Vehicle();
    }
}
