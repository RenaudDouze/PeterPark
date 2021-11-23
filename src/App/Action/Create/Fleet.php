<?php

namespace App\Action\Create;

use Domain\Entity\Fleet;

class Fleet
{
	public static function do(): Fleet
	{
		return new Fleet();
	}
}