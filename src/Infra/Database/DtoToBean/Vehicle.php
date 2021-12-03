<?php

declare(strict_types = 1);

namespace Infra\Database\DtoToBean;

use \Infra\Database\Dto\Vehicle as VehicleDTO;
use \RedBeanPHP\OODBBean;
use \RedBeanPHP\R;

class Vehicle
{
    public static function dtoToBean(VehicleDTO $dto) : OODBBean
    {
        $bean = R::dispense('vehicle', 1, false);

        if (! $bean instanceof OODBBean) {
            throw new \RuntimeException('This is not an OODBBean');
        }

        $bean->setAttr('location', $dto->location);
        $bean->setAttr('plateNumber', $dto->plateNumber);

        return $bean;
    }
}
