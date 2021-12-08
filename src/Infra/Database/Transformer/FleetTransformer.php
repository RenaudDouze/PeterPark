<?php

declare(strict_types = 1);

namespace Infra\Database\Transformer;

use \Domain\Entity\Fleet;
use \RedBeanPHP\OODBBean;
use \RedBeanPHP\R;

class FleetTransformer
{
    public static function entityToBean(Fleet $fleet) : OODBBean
    {
        $bean = $fleet->getId()
            ? R::load(Fleet::BEAN_NAME, $fleet->getId())
            : R::dispense(Fleet::BEAN_NAME);

        $bean->ownerId = $fleet->getOwnerId();

        if ($fleet->getVehicles()) {
            $bean->ownVehicleList = [];

            foreach ($fleet->getVehicles() as $vehicle) {
                $bean->ownVehicleList[] = VehicleTransformer::entityToBean($vehicle);
            }
        }

        return $bean;
    }

    public static function beanToEntity(OODBBean $bean) : Fleet
    {
        $fleet = new Fleet($bean->ownerId);
        $fleet->setId((int) $bean->getID());

        if ($bean->ownVehicleList) {
            foreach ($bean->ownVehicleList as $vehicleBean) {
                $fleet->add(VehicleTransformer::beanToEntity($vehicleBean));
            }
        }

        return $fleet;
    }
}
