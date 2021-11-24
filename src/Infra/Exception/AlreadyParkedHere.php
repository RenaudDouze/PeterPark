<?php

declare(strict_types = 1);

namespace Infra\Exception;

class AlreadyParkedHere extends \Exception
{
    public $message = 'The vehicle is already parked here';
}
