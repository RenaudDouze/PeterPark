<?php

declare(strict_types = 1);

namespace Infra\Database\DtoToBean;

use \Infra\Database\Dto\Fleet as FleetDTO;
use \RedBeanPHP\OODBBean;
use \RedBeanPHP\R;

class Fleet
{
    public static function dtoToBean(FleetDTO $dto) : OODBBean
    {
        $bean = R::dispense('fleet', 1, false);

        if (! $bean instanceof OODBBean) {
            throw new \RuntimeException('This is not an OODBBean');
        }

        $bean->ownerId = $dto->ownerId;
        $bean->vehicles = $dto->vehicles;

        return $bean;
    }
}
