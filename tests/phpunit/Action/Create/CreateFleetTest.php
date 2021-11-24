<?php

namespace Tests\PHPUnit\Action\Create;

use App\Action\Create\CreateFleet;
use Domain\Entity\Fleet;
use PHPUnit\Framework\TestCase;

class CreateFleetTest extends TestCase
{
    public function testDo()
    {
        $this->assertInstanceOf(Fleet::class, CreateFleet::do());
    }
}
