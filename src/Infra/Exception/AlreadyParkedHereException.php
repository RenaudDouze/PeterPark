<?php

namespace Infra\Exception;

class AlreadyParkedHereException extends \Exception
{
    public $message = "The vehicle is already parked here";
}
