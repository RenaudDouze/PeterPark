<?php

declare(strict_types = 1);

namespace App\Action\Save;

use \Domain\Entity\Fleet;
use \Infra\Database\Transformer\FleetTransformer;
use \RedBeanPHP\R;

class SaveFleet
{
    public static function do(Fleet $fleet) : int
    {
        $bean = FleetTransformer::entityToBean($fleet);

        return (int) R::store($bean);
    }
}
