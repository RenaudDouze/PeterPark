<?php

namespace Domain\Entity;

use Infra\Exception\AlreadyInFleetException;

class Fleet
{
    private array $vehicles = [];

    /**
     * @throws AlreadyInFleetException
     */
    public function add(Vehicle $vehicle): int
    {
        if ($this->isIn($vehicle)) {
            throw new AlreadyInFleetException();
        }

        $this->vehicles[] = $vehicle;

        return count($this->vehicles);
    }

    public function isIn(Vehicle $vehicle): bool
    {
        return in_array($vehicle, $this->vehicles);
    }
}
