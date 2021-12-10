<?php

declare(strict_types = 1);

namespace Tests\PHPUnit\App\Action\Save;

use \App\Action\Save\SaveLocation;
use \Domain\Entity\Location;
use \PHPUnit\Framework\TestCase;
use \RedBeanPHP\R;
use \Tests\Tools\Infra\Database\Db;

class SaveLocationTest extends TestCase
{
    public function testDo() : void
    {
        $location = new Location('08', '58');

        $id = SaveLocation::do($location);

        $this->assertIsInt($id);

        $dbLocation = R::load('location', $id);

        $this->assertEquals('08', $dbLocation->latitude);
        $this->assertEquals('58', $dbLocation->longitude);
        $this->assertEquals(0, $dbLocation->altitude);
    }

    public function testDoWithAltitude() : void
    {
        $location = new Location('08', '58', 458);

        $id = SaveLocation::do($location);

        $this->assertIsInt($id);

        $dbLocation = R::load('location', $id);

        $this->assertEquals('08', $dbLocation->latitude);
        $this->assertEquals('58', $dbLocation->longitude);
        $this->assertEquals(458, $dbLocation->altitude);
    }

    /**
     * @before
     */
    public function setUp() : void
    {
        Db::connect();
    }

    /**
     * @after
     */
    public function tearDown() : void
    {
        R::close();
    }
}
