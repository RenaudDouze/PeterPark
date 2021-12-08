<?php

declare(strict_types = 1);

namespace App\Action\Save;

use \Domain\Entity\Location;
use \Infra\Database\Transformer\LocationTransformer;
use \RedBeanPHP\R;

class SaveLocation
{
    public static function do(Location $location) : int
    {
        $bean = LocationTransformer::entityToBean($location);

        return (int) R::store($bean);
    }
}
