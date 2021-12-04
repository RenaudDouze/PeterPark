<?php

declare(strict_types = 1);

namespace Tests\PHPUnit\Infra\DTO;

use \Domain\Entity\Location as LocationEntity;
use \Infra\Database\DTO\Location as LocationDTO;
use \PHPUnit\Framework\TestCase;

class LocationTest extends TestCase
{
    public function testCreateFromEntity() : void
    {
        $location = new LocationEntity('R', '42');

        $dto = LocationDTO::createFromEntity($location);

        $this->assertEquals('R', $dto->longitude);
        $this->assertEquals('42', $dto->latitude);
    }
}
