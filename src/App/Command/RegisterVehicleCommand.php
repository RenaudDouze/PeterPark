<?php

declare(strict_types = 1);

namespace App\Command;

use \App\Action\Create\CreateVehicle;
use \App\Action\RegisterVehicle\RegisterVehicle;
use \Infra\Database\Db;
use \Infra\Database\Transformer\FleetTransformer;
use \RedBeanPHP\R;
use \Symfony\Component\Console\Command\Command;
use \Symfony\Component\Console\Input\InputArgument;
use \Symfony\Component\Console\Input\InputInterface;
use \Symfony\Component\Console\Output\OutputInterface;

class RegisterVehicleCommand extends Command
{
    protected static $defaultName = 'register-vehicle';

    protected function configure() : void
    {
        $this->setHelp('Register a Vehicle to a Fleet');
        $this->addArgument('fleetId', InputArgument::REQUIRED, 'The fleet id');
        $this->addArgument('vehiclePlateNumber', InputArgument::REQUIRED, 'The vehicle plate number');
    }

    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        Db::connect();

        $loadedFleet = R::findOne('fleet', 'id = ?', [$input->getArgument('fleetId')]);
        $fleet = FleetTransformer::beanToEntity($loadedFleet);

        $vehicle = CreateVehicle::do($input->getArgument('vehiclePlateNumber'));
        $fleet = RegisterVehicle::do($vehicle, $fleet);

        // Update the fleet
        R::store(FleetTransformer::entityToBean($fleet));

        $output->writeln('Vehicle `' . $vehicle->getPlateNumber() . '` registered onto Fleet `' . $fleet->getID() . '`');

        Db::disconnect();

        return Command::SUCCESS;
    }
}
