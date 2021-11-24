<?php

namespace App\Action\Create;

use Domain\Entity\Fleet;

class CreateFleet
{
    public static function do(): Fleet
    {
        return new Fleet();
    }
}
