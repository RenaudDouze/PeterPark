<?php

declare(strict_types = 1);

namespace App\Command;

use \App\Action\Create\CreateLocation;
use \Infra\Database\Db;
use \Infra\Database\Transformer\VehicleTransformer;
use \RedBeanPHP\R;
use \Symfony\Component\Console\Command\Command;
use \Symfony\Component\Console\Input\InputArgument;
use \Symfony\Component\Console\Input\InputInterface;
use \Symfony\Component\Console\Output\OutputInterface;

class LocalizeVehicleCommand extends Command
{
    protected static $defaultName = 'localize-vehicle';

    protected function configure() : void
    {
        $this->setHelp('Park a Vehicle somewhere');
        $this->addArgument('fleetId', InputArgument::REQUIRED, 'The fleet id');
        $this->addArgument('vehiclePlateNumber', InputArgument::REQUIRED, 'The vehicle plate number');
        $this->addArgument('lat', InputArgument::REQUIRED, 'The place latitude');
        $this->addArgument('lon', InputArgument::REQUIRED, 'The place longitude');
        $this->addArgument('alt', InputArgument::OPTIONAL, 'The place altitude');
    }

    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        Db::connect();

        $bean = R::findOne(
            'vehicle',
            ' plate_number =  ? AND fleet_id = ?',
            [
                $input->getArgument('vehiclePlateNumber'),
                $input->getArgument('fleetId'),
            ],
        );
        $vehicle = VehicleTransformer::beanToEntity($bean);

        $latitude = $input->getArgument('lat');
        $longitude = $input->getArgument('lon');
        $altitude = $input->getArgument('alt');
        $location = CreateLocation::do($latitude, $longitude, $altitude);

        $vehicle->park($location);

        // Update the fleet
        R::store(VehicleTransformer::entityToBean($vehicle));

        if ($altitude === null) {
            $output->writeln(\sprintf('Vehicle `%s` parked at `%s, %s`', $vehicle->getPlateNumber(), $latitude, $longitude));
        } else {
            $output->writeln(\sprintf('Vehicle `%s` parked at `%s, %s, %s`', $vehicle->getPlateNumber(), $latitude, $longitude, $altitude));
        }

        Db::disconnect();

        return Command::SUCCESS;
    }
}
