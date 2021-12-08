<?php

declare(strict_types = 1);

namespace Tests\PHPUnit\Domain\Entity;

use \Domain\Entity\Location;
use \Infra\Database\Transformer\LocationTransformer;
use \PHPUnit\Framework\TestCase;
use \RedBeanPHP\OODBBean;
use \RedBeanPHP\R;

class LocationTest extends TestCase
{
    public function testGetters() : void
    {
        $location = new Location('B', '2');

        $this->assertEquals('B', $location->getLatitude());
        $this->assertEquals('2', $location->getLongitude());
        $this->assertEquals(0, $location->getAltitude());
    }

    public function testGettersWithAltitude() : void
    {
        $location = new Location('B', '2', -1.25);

        $this->assertEquals('B', $location->getLatitude());
        $this->assertEquals('2', $location->getLongitude());
        $this->assertEquals(-1.25, $location->getAltitude());
    }

    public function testCreateFromBean() : void
    {
        $beanLocation = R::dispense('location', 1, false);
        \assert($beanLocation instanceof OODBBean);

        $beanLocation->latitude = 'plus haut';
        $beanLocation->longitude = 'un peu plus à droite';

        if (! ($beanLocation instanceof OODBBean)) {
            throw new \RuntimeException();
        }

        $location = LocationTransformer::beanToEntity($beanLocation);

        $this->assertEquals('plus haut', $location->getLatitude());
        $this->assertEquals('un peu plus à droite', $location->getLongitude());
    }

    public function testCreateFromBeanWithAltitude() : void
    {
        $beanLocation = R::dispense('location', 1, false);
        \assert($beanLocation instanceof OODBBean);

        $beanLocation->latitude = 'plus haut';
        $beanLocation->longitude = 'un peu plus à droite';
        $beanLocation->altitude = 15.6;

        if (! ($beanLocation instanceof OODBBean)) {
            throw new \RuntimeException();
        }

        $location = LocationTransformer::beanToEntity($beanLocation);

        $this->assertEquals('plus haut', $location->getLatitude());
        $this->assertEquals('un peu plus à droite', $location->getLongitude());
        $this->assertEquals(15.6, $location->getAltitude());
    }
}
