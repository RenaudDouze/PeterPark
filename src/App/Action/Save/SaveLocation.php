<?php

declare(strict_types = 1);

namespace App\Action\Save;

use \Domain\Entity\Location as LocationEntity;
use \Infra\Database\Dto\Location as LocationDto;
use \Infra\Database\DtoToBean\Location as LocationDtoToBean;
use \RedBeanPHP\OODBBean;

class SaveLocation
{
    public static function do(LocationEntity $fleet) : OODBBean
    {
        $dtoLocation = LocationDto::createFromEntity($fleet);

        return LocationDtoToBean::dtoToBean($dtoLocation);
    }
}
