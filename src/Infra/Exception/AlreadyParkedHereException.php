<?php

namespace Infra\Exception;

class AlreadyParkedHereException extends \Exception
{
	string $message = "The vehicle is already parked here";
}