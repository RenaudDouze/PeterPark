<?php

declare(strict_types = 1);

namespace Tests\PHPUnit\App\Command;

use \App\Action\Save\SaveFleet;
use \Domain\Entity\Fleet;
use \Domain\Entity\Vehicle;
use \Infra\Database\Db;
use \PHPUnit\Framework\TestCase;
use \RedBeanPHP\R;
use \Symfony\Component\Console\Application;
use \Symfony\Component\Console\Tester\CommandTester;

class LocalizeVehicleCommandTest extends TestCase
{
    private Application $application;
    private int $fleetId;

    public function testExecute() : void
    {
        $command = $this->application->find('localize-vehicle');
        $commandTester = new CommandTester($command);

        $commandTester->execute([
            'fleetId' => $this->fleetId,
            'vehiclePlateNumber' => '724 LNB 13',
            'lat' => '45,830921',
            'lon' => '1,256300',
        ]);

        $commandTester->assertCommandIsSuccessful();
        $output = $commandTester->getDisplay();

        $regexp = '/^Vehicle `724 LNB 13` parked at `45,830921, 1,256300`/';
        $this->assertMatchesRegularExpression($regexp, $output);

        $vehicle = R::findOne(
            'vehicle',
            ' plate_number =  ? AND fleet_id = ?',
            [
                '724 LNB 13',
                $this->fleetId,
            ],
        );
        $this->assertEquals('45,830921', $vehicle->location->latitude);
        $this->assertEquals('1,256300', $vehicle->location->longitude);
        $this->assertEquals(0, $vehicle->location->altitude);
    }

    public function testExecuteWithAltitude() : void
    {
        $command = $this->application->find('localize-vehicle');
        $commandTester = new CommandTester($command);

        $commandTester->execute([
            'fleetId' => $this->fleetId,
            'vehiclePlateNumber' => '724 LNB 13',
            'lat' => '45,830921',
            'lon' => '1,256300',
            'alt' => 1.2,
        ]);

        $commandTester->assertCommandIsSuccessful();
        $output = $commandTester->getDisplay();

        $regexp = '/^Vehicle `724 LNB 13` parked at `45,830921, 1,256300, 1.2`/';
        $this->assertMatchesRegularExpression($regexp, $output);

        $vehicle = R::findOne(
            'vehicle',
            ' plate_number =  ? AND fleet_id = ?',
            [
                '724 LNB 13',
                $this->fleetId,
            ],
        );
        $this->assertEquals('45,830921', $vehicle->location->latitude);
        $this->assertEquals('1,256300', $vehicle->location->longitude);
        $this->assertEquals(1.2, $vehicle->location->altitude);
    }

    public function testExecuteWithoutArgument() : void
    {
        $command = $this->application->find('localize-vehicle');
        $commandTester = new CommandTester($command);

        $this->expectException(\Symfony\Component\Console\Exception\RuntimeException::class);

        $commandTester->execute([]);
    }

    protected function setUp() : void
    {
        \putenv('DATABASE_CONNEXION_QUERY=sqlite:tests/resources/db/file.db');
        \putenv('DATABASE_DB_NAME=this-is-a-database-name');
        \putenv('DATABASE_PASSWORD=a-very-secure-password-that-nobody-will-ever-know');

        $this->application = new Application();
        $this->application->add(new \App\Command\LocalizeVehicleCommand());

        Db::connect();

        $vehicle = new Vehicle('724 LNB 13');

        $fleet = new Fleet('Daniel');
        $fleet->add($vehicle);

        $this->fleetId = SaveFleet::do($fleet);
    }
}
