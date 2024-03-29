<?php

declare(strict_types = 1);

namespace App\Command;

use \App\Action\Create\CreateFleet;
use \App\Action\Save\SaveFleet;
use \Infra\Database\Db;
use \Symfony\Component\Console\Command\Command;
use \Symfony\Component\Console\Input\InputArgument;
use \Symfony\Component\Console\Input\InputInterface;
use \Symfony\Component\Console\Output\OutputInterface;

class CreateFleetCommand extends Command
{
    protected static $defaultName = 'create';

    protected function configure() : void
    {
        $this->setHelp('Create a Fleet for a given user id');
        $this->addArgument('userId', InputArgument::REQUIRED, 'The fleet owner id');
    }

    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        Db::connect();

        $fleet = CreateFleet::do($input->getArgument('userId'));
        $id = SaveFleet::do($fleet);

        $output->writeln('Fleet saved. Id is `' . $id . '`');

        Db::disconnect();

        return Command::SUCCESS;
    }
}
