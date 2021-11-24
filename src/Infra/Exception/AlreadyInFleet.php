<?php

declare(strict_types = 1);

namespace Infra\Exception;

class AlreadyInFleet extends \Exception
{
    public $message = 'The vehicle is already in this AlreadyInFleetException';
}
