<?php

namespace Domain\Entity;

use Info/Exception/AlreadyInFleetException;

class Fleet
{
	private array $vehicles = [];

	public function add(Vehicle $vehicle): void
	{
		if ($this->isIn($vehicle)) {
			throw new AlreadyInFleetException();
		}

		$this->vehicles[] = $vehicle; 
	} 

	public function isIn(Vehicle $vehicle): bool
	{
		return in_array($vehicle, $this->vehicles);
	}
}