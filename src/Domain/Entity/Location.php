<?php

namespace Domain\Entity;

class Location
{
    private string $longitude;
    private string $latitude;

    public function __construct(string $longitude, string $latitude)
    {
        // Some controls to be sure args are valid longitude and latitude
        // but there is so many formats
        // Maybe https://packagist.org/packages/league/geotools will do it

        $this->longitude = $longitude;
        $this->latitude = $latitude;
    }
}
