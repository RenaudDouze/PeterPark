<?php

declare(strict_types = 1);

namespace App\Action\Save;

use \Domain\Entity\Fleet as FleetEntity;
use \Infra\Database\Dto\Fleet as FleetDto;
use \Infra\Database\DtoToBean\Fleet as FleetDtoToBean;
use \RedBeanPHP\OODBBean;

class SaveFleet
{
    public static function do(FleetEntity $fleet) : OODBBean
    {
        $dtoFleet = FleetDto::createFromEntity($fleet);

        return FleetDtoToBean::dtoToBean($dtoFleet);
    }
}
