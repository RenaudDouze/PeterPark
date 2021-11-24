<?php

declare(strict_types = 1);

namespace Domain\Entity;

class Location
{
    public function __construct(
        private string $longitude,
        private string $latitude,
    )
    {
        // Some controls to be sure args are valid longitude and latitude
        // but there is so many formats
        // Maybe https://packagist.org/packages/league/geotools will do it
    }
}
