<?php

declare(strict_types = 1);

namespace Infra\Database\Transformer;

use \Domain\Entity\Location;
use \RedBeanPHP\OODBBean;
use \RedBeanPHP\R;

class LocationTransformer
{
    public static function entityToBean(Location $location) : OODBBean
    {
        $bean = $location->getId()
            ? R::load(Location::BEAN_NAME, $location->getId())
            : R::dispense(Location::BEAN_NAME);

        $bean->latitude = $location->getLatitude();
        $bean->longitude = $location->getLongitude();
        $bean->altitude = $location->getAltitude();

        return $bean;
    }

    public static function beanToEntity(OODBBean $bean) : Location
    {
        $location = new Location($bean->latitude, $bean->longitude, (float) $bean->altitude);
        $location->setId((int) $bean->getID());

        return $location;
    }
}
