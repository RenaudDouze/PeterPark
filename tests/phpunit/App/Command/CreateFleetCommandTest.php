<?php

declare(strict_types = 1);

namespace Tests\PHPUnit\App\Command;

use \Infra\Database\Db;
use \PHPUnit\Framework\TestCase;
use \RedBeanPHP\R;
use \Symfony\Component\Console\Application;
use \Symfony\Component\Console\Tester\CommandTester;

class CreateFleetCommandTest extends TestCase
{
    private Application $application;

    public function testExecute() : void
    {
        $command = $this->application->find('create');
        $commandTester = new CommandTester($command);

        $commandTester->execute([
            'userId' => 'douze',
        ]);

        $commandTester->assertCommandIsSuccessful();
        $output = $commandTester->getDisplay();

        $regexp = '/^Fleet saved. Id is `(\d+)`/';
        $this->assertMatchesRegularExpression($regexp, $output);

        $matches = [];
        \preg_match($regexp, $output, $matches);

        $fleetId = $matches[1];
        $fleet = R::load('fleet', $fleetId);

        $this->assertEquals('douze', $fleet->ownerId);
    }

    public function testExecuteWithoutArgument() : void
    {
        $command = $this->application->find('create');
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
        $this->application->add(new \App\Command\CreateFleetCommand());

        Db::connect();
    }
}
