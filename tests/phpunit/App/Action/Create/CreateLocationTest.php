<?php

declare(strict_types = 1);

namespace Tests\PHPUnit\Action\Create;

use \App\Action\Create\CreateLocation;
use \Domain\Entity\Location;
use \PHPUnit\Framework\TestCase;

class CreateLocationTest extends TestCase
{
    public function testDo() : void
    {
        $this->assertInstanceOf(Location::class, CreateLocation::do('vers', 'la'));
    }
}
