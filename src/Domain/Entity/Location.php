<?php

declare(strict_types = 1);

namespace Domain\Entity;

class Location
{
    public const BEAN_NAME = 'location';

    /** @var int|null Database id */
    private ?int $id = null;

    public function __construct(
        private string $latitude,
        private string $longitude,
        private float $altitude = 0,
    )
    {
        // Some controls to be sure args are valid longitude and latitude
        // but there is so many formats
        // Maybe https://packagist.org/packages/league/geotools will do it
    }

    public function getLatitude() : string
    {
        return $this->latitude;
    }

    public function getLongitude() : string
    {
        return $this->longitude;
    }

    public function getAltitude() : float
    {
        return $this->altitude;
    }

    public function getId() : ?int
    {
        return $this->id;
    }

    public function setId(?int $id) : void
    {
        $this->id = $id;
    }
}
