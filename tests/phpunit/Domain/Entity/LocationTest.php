<?php

declare(strict_types = 1);

namespace Tests\PHPUnit\Domain\Entity;

use \Domain\Entity\Location;
use \PHPUnit\Framework\TestCase;

class LocationTest extends TestCase
{
    public function testGetters() : void
    {
        $location = new Location('B', '2');

        $this->assertEquals('B', $location->getLongitude());
        $this->assertEquals('2', $location->getLatitude());
    }
}
