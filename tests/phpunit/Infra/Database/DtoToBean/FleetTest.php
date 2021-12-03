<?php

declare(strict_types = 1);

namespace Tests\PHPUnit\Infra\Database\DtoToBean;

use \Domain\Entity\Fleet as FleetEntity;
use \Infra\Database\Dto\Fleet as FleetDto;
use \Infra\Database\DtoToBean\Fleet as FleetDtoToBean;
use \PHPUnit\Framework\TestCase;

class FleetTest extends TestCase
{
    public function testDtoToBean() : void
    {
        $entity = new FleetEntity('Toto');
        $dto = FleetDto::createFromEntity($entity);

        $bean = FleetDtoToBean::dtoToBean($dto);

        $this->assertEquals($entity->getOwnerId(), $bean->ownerId);
        $this->assertEquals($entity->getVehicles(), $bean->vehicles);
    }
}
