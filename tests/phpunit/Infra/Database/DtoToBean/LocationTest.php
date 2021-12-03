<?php

declare(strict_types = 1);

namespace Tests\PHPUnit\Infra\Database\DtoToBean;

use \Domain\Entity\Location as LocationEntity;
use \Infra\Database\Dto\Location as LocationDto;
use \Infra\Database\DtoToBean\Location as LocationDtoToBean;
use \PHPUnit\Framework\TestCase;

class LocationTest extends TestCase
{
    public function testDtoToBean() : void
    {
        $entity = new LocationEntity('Haut', 'Droite');
        $dto = LocationDto::createFromEntity($entity);

        $bean = LocationDtoToBean::dtoToBean($dto);

        $this->assertEquals($entity->getLongitude(), $bean->longitude);
        $this->assertEquals($entity->getLatitude(), $bean->latitude);
    }
}
