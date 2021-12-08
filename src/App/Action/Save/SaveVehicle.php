<?php

declare(strict_types = 1);

namespace App\Action\Save;

use \Domain\Entity\Vehicle;
use \Infra\Database\Transformer\VehicleTransformer;
use \RedBeanPHP\R;

class SaveVehicle
{
    public static function do(Vehicle $vehicle) : int
    {
        $bean = VehicleTransformer::entityToBean($vehicle);

        return (int) R::store($bean);
    }
}
