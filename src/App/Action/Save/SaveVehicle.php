<?php

declare(strict_types = 1);

namespace App\Action\Save;

use \Domain\Entity\Vehicle as VehicleEntity;
use \Infra\Database\Dto\Vehicle as VehicleDto;
use \Infra\Database\DtoToBean\Vehicle as VehicleDtoToBean;
use \RedBeanPHP\OODBBean;

class SaveVehicle
{
    public static function do(VehicleEntity $fleet) : OODBBean
    {
        $dtoVehicle = VehicleDto::createFromEntity($fleet);

        return VehicleDtoToBean::dtoToBean($dtoVehicle);
    }
}
