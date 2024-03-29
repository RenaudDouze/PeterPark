#!/usr/bin/env php
<?php

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->usePutenv(true);
$dotenv->load(__DIR__.'/.env');

$application = new Application();

$application->add(new \App\Command\CreateFleetCommand());

$application->run();
