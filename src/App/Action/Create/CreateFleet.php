<?php

declare(strict_types = 1);

namespace App\Action\Create;

use \Domain\Entity\Fleet;

class CreateFleet
{
    public static function do(string $ownerId) : Fleet
    {
        return new Fleet($ownerId);
    }
}
