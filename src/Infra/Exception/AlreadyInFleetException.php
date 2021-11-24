<?php

namespace Infra\Exception;

class AlreadyInFleetException extends \Exception
{
    public $message = "The vehicle is already in this AlreadyInFleetException";
}
