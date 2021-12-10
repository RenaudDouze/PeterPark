<?php

declare(strict_types = 1);

namespace Infra\Database\Transformer;

use \Domain\Entity\Vehicle;
use \RedBeanPHP\OODBBean;
use \RedBeanPHP\R;

class VehicleTransformer
{
    public static function entityToBean(Vehicle $vehicle) : OODBBean
    {
        $bean = $vehicle->getId()
            ? R::load(Vehicle::BEAN_NAME, $vehicle->getId())
            : R::dispense(Vehicle::BEAN_NAME);

        $bean->plateNumber = $vehicle->getPlateNumber();

        if ($vehicle->whereIs()) {
            $bean->location = LocationTransformer::entityToBean($vehicle->whereIs());
        }

        return $bean;
    }

    public static function beanToEntity(OODBBean $bean) : Vehicle
    {
        $vehicle = new Vehicle($bean->plateNumber);
        $vehicle->setId((int) $bean->getID());

        if ($bean->location) {
            $vehicle->park(LocationTransformer::beanToEntity($bean->location));
        }

        return $vehicle;
    }
}
