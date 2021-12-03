<?php

declare(strict_types = 1);

namespace Tests\PHPUnit\Infra\Database\DtoToBean;

use \Domain\Entity\Vehicle as VehicleEntity;
use \Infra\Database\Dto\Vehicle as VehicleDto;
use \Infra\Database\DtoToBean\Vehicle as VehicleDtoToBean;
use \PHPUnit\Framework\TestCase;

class VehicleTest extends TestCase
{
    public function testDtoToBean() : void
    {
        $entity = new VehicleEntity('012-ABC-34');
        $dto = VehicleDto::createFromEntity($entity);

        $bean = VehicleDtoToBean::dtoToBean($dto);

        $this->assertEquals($entity->whereIs(), $bean->location);
        $this->assertEquals($entity->getPlateNumber(), $bean->plateNumber);
    }
}
