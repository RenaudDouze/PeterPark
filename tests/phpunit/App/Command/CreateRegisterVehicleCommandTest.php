<?php

declare(strict_types = 1);

namespace Tests\PHPUnit\App\Command;

use \App\Action\Save\SaveFleet;
use \Domain\Entity\Fleet;
use \Infra\Database\Db;
use \PHPUnit\Framework\TestCase;
use \RedBeanPHP\R;
use \Symfony\Component\Console\Application;
use \Symfony\Component\Console\Tester\CommandTester;

class CreateRegisterVehicleCommandTest extends TestCase
{
    private Application $application;
    private int $fleetId;

    public function testExecute() : void
    {
        $command = $this->application->find('register-vehicle');
        $commandTester = new CommandTester($command);

        $commandTester->execute([
            'fleetId' => $this->fleetId,
            'vehiclePlateNumber' => '724 LNB 13',
        ]);

        $commandTester->assertCommandIsSuccessful();
        $output = $commandTester->getDisplay();

        $regexp = '/^Vehicle `724 LNB 13` registered onto Fleet `\d+`/';
        $this->assertMatchesRegularExpression($regexp, $output);

        $vehicle = R::findOne(
            'vehicle',
            ' plate_number =  ? AND fleet_id = ?',
            [
                '724 LNB 13',
                $this->fleetId,
            ],
        );
        $this->assertEquals('724 LNB 13', $vehicle->plateNumber);
    }

    public function testExecuteWithoutArgument() : void
    {
        $command = $this->application->find('register-vehicle');
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
        $this->application->add(new \App\Command\RegisterVehicleCommand());

        Db::connect();

        $fleet = new Fleet('Daniel');
        $this->fleetId = SaveFleet::do($fleet);
    }
}
