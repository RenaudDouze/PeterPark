<?php

declare(strict_types = 1);

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use \App\Action\Create;
use \App\Action\ParkVehicle;
use \App\Action\RegisterVehicle;
use \Behat\Behat\Context\Context;
use \Domain\Entity\Fleet;
use \Domain\Entity\Location;
use \Domain\Entity\Vehicle;
use \PHPUnit\Framework\Assert;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    private ?Vehicle $vehicle;
    private ?Fleet $firstFleet;
    private ?Fleet $secondFleet;
    private ?Location $location;
    private ?\Throwable $exception;

    /** @Given my fleet */
    public function myFleet() : void
    {
        $this->firstFleet = Create\CreateFleet::do();
    }

    /** @Given the fleet of another user */
    public function theFleetOfAnotherUser() : void
    {
        $this->secondFleet = Create\CreateFleet::do();
    }

    /** @Given a vehicle */
    public function aVehicle() : void
    {
        $this->vehicle = Create\CreateVehicle::do();
    }

    /** @Given a location */
    public function aLocation() : void
    {
        $this->location = Create\CreateLocation::do((string) \rand(), (string) \rand());
    }

    /** @Given I have registered this vehicle into my fleet */
    public function iHaveRegisteredThisVehicleIntoMyFleet() : void
    {
        if ($this->vehicle === null || $this->firstFleet === null) {
            throw new \RuntimeException("You must call both 'Given a vehicle' and 'Given my fleet' first");
        }

        RegisterVehicle\RegisterVehicle::do($this->vehicle, $this->firstFleet);
    }

    /** @When I park my vehicle at this location */
    public function iParkMyVehicleAtThisLocation() : void
    {
        if ($this->vehicle === null || $this->location === null) {
            throw new \RuntimeException("You must call both 'Given a vehicle' and 'Given a location' first");
        }

        ParkVehicle\Park::do($this->vehicle, $this->location);
    }

    /** @Then the known location of my vehicle should verify this location */
    public function theKnownLocationOfMyVehicleShouldVerifyThisLocation() : void
    {
        Assert::assertEquals($this->location, ParkVehicle\DudeWheresMyCar::get($this->vehicle));
    }

    /** @Given my vehicle has been parked into this location */
    public function myVehicleHasBeenParkedIntoThisLocation() : void
    {
        if ($this->vehicle === null || $this->location === null) {
            throw new \RuntimeException("You must call both 'Given a vehicle' and 'Given a location' first");
        }

        ParkVehicle\Park::do($this->vehicle, $this->location);
    }

    /** @When I try to park my vehicle at this location */
    public function iTryToParkMyVehicleAtThisLocation() : void
    {
        if ($this->vehicle === null || $this->location === null) {
            throw new \RuntimeException("You must call both 'Given a vehicle' and 'Given a location' first");
        }

        try {
            ParkVehicle\Park::do($this->vehicle, $this->location);
        } catch (\Throwable $e) {
            $this->exception = $e;
        }
    }

    /** @Then I should be informed that my vehicle is already parked at this location */
    public function iShouldBeInformedThatMyVehicleIsAlreadyParkedAtThisLocation() : void
    {
        Assert::assertInstanceOf(\Infra\Exception\AlreadyParkedHere::class, $this->exception->getPrevious());
    }

    /** @When I register this vehicle into my fleet */
    public function iRegisterThisVehicleIntoMyFleet() : void
    {
        if ($this->vehicle === null || $this->firstFleet === null) {
            throw new \RuntimeException("You must call both 'Given a vehicle' and 'Given my fleet' first");
        }

        RegisterVehicle\RegisterVehicle::do($this->vehicle, $this->firstFleet);
    }

    /** @Then this vehicle should be part of my vehicle fleet */
    public function thisVehicleShouldBePartOfMyVehicleFleet() : void
    {
        if ($this->vehicle === null || $this->firstFleet === null) {
            throw new \RuntimeException("You must call both 'Given a vehicle' and 'Given my fleet' first");
        }

        RegisterVehicle\IsRegistered::check($this->vehicle, $this->firstFleet);
    }

    /** @When I try to register this vehicle into my fleet */
    public function iTryToRegisterThisVehicleIntoMyFleet() : void
    {
        if ($this->vehicle === null || $this->firstFleet === null) {
            throw new \RuntimeException("You must call both 'Given a vehicle' and 'Given my fleet' first");
        }

        try {
            RegisterVehicle\RegisterVehicle::do($this->vehicle, $this->firstFleet);
        } catch (\Throwable $e) {
            $this->exception = $e;
        }
    }

    /** @Then I should be informed this this vehicle has already been registered into my fleet */
    public function iShouldBeInformedThisThisVehicleHasAlreadyBeenRegisteredIntoMyFleet() : void
    {
        Assert::assertInstanceOf(\Infra\Exception\AlreadyInFleet::class, $this->exception->getPrevious());
    }

    /** @Given this vehicle has been registered into the other user's fleet */
    public function thisVehicleHasBeenRegisteredIntoTheOtherUsersFleet() : void
    {
        if ($this->vehicle === null || $this->secondFleet === null) {
            throw new \RuntimeException("You must call both 'Given a vehicle' and 'Given the fleet of another user' first");
        }

        RegisterVehicle\RegisterVehicle::do($this->vehicle, $this->secondFleet);
    }
}
