<?php

declare(strict_types = 1);

namespace Infra\Database\DtoToBean;

use \Infra\Database\Dto\Location as LocationDTO;
use \RedBeanPHP\OODBBean;
use \RedBeanPHP\R;

class Location
{
    public static function dtoToBean(LocationDTO $dto) : OODBBean
    {
        $bean = R::dispense('location', 1, false);

        if (! $bean instanceof OODBBean) {
            throw new \RuntimeException('This is not an OODBBean');
        }

        $bean->setAttr('longitude', $dto->longitude);
        $bean->setAttr('latitude', $dto->latitude);

        return $bean;
    }
}
