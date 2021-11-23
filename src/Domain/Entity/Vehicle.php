<?php

namespace Domain\Entity;

use Infra\Exception\AlreadyParkedHereException

class Vehicle
{
	// Better with an uuid
	// The only purpose is to differentiate each Vehicle
	private string $id;

	private ?Location $location = null;

	public function __construct()
	{
		$this->id = uniqid();
	}

	public function whereIs(): ?Location
	{
		return $location
	}

	public function park(Location $location): void
	{
		if ($this->location === $location) {
			throw new AlreadyParkedHereException("Error Processing Request", 1);
		}

		$this->location = $location;
	}
}