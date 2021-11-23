<?php

namespace Infra\Exception;

class AlreadyInFleetException extends \Exception
{
	string $message = "The vehicle is already in this AlreadyInFleetException";
}