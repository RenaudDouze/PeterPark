<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use Domain\Entity\Vehicle;
use Domain\Entity\Fleet;
use Domain\Entity\Location;

use App\Action\Create;
use App\Action\ParkVehicle;
use App\Action\RegisterVehicle;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    private ?Vehicle $vehicle;

    private ?Fleet $firstFleet;
    private ?Fleet $secondFleet;

    private ?Location $location;

    private ?\Exception $exception;


    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given my fleet
     */
    public function myFleet()
    {
        $this->firstFleet = Create\Fleet::do();
    }

    /**
     * @Given the fleet of another user
     */
    public function theFleetOfAnotherUser()
    {
        $this->secondFleet = Create\Fleet::do();
    }

    /**
     * @Given a vehicle
     */
    public function aVehicle()
    {
        $this->vehicle = Create\Vehicle::do();
    }

    /**
     * @Given a location
     */
    public function aLocation()
    {
        $this->location = Create\Location::do();
    }

    /**
     * @Given I have registered this vehicle into my fleet
     */
    public function iHaveRegisteredThisVehicleIntoMyFleet()
    {
        RegisterVehicle\RegisterVehicle::do($this->vehicle, $this->firstFleet);
    }

    /**
     * @When I park my vehicle at this location
     */
    public function iParkMyVehicleAtThisLocation()
    {
        ParkVehicle\Park::do($this->vehicle, $this->location);
    }

    /**
     * @Then the known location of my vehicle should verify this location
     */
    public function theKnownLocationOfMyVehicleShouldVerifyThisLocation()
    {
        PHPUnit_Framework_Assert::assertEquals($this->location, ParkVehicle\DudeWheresMyCar::get($this->vehicle));
    }

    /**
     * @Given my vehicle has been parked into this location
     */
    public function myVehicleHasBeenParkedIntoThisLocation()
    {
        ParkVehicle\Park::do($this->vehicle, $this->location);
    }

    /**
     * @When I try to park my vehicle at this location
     */
    public function iTryToParkMyVehicleAtThisLocation()
    {
        try {
            ParkVehicle\Park::do($this->vehicle, $this->location);
        } catch (\Exception $e) {
            $this->exception = $e;
        }
    }

    /**
     * @Then I should be informed that my vehicle is already parked at this location
     */
    public function iShouldBeInformedThatMyVehicleIsAlreadyParkedAtThisLocation()
    {
        PHPUnit_Framework_Assert::assertInstanceOf(Infra\Exception\AlreadyParkedHereException, $this->exception->getPrevious());
    }

    /**
     * @When I register this vehicle into my fleet
     */
    public function iRegisterThisVehicleIntoMyFleet()
    {
        RegisterVehicle\RegisterVehicle::do($this->vehicle, $this->firstFleet);
    }

    /**
     * @Then this vehicle should be part of my vehicle fleet
     */
    public function thisVehicleShouldBePartOfMyVehicleFleet()
    {
        RegisterVehicle\IsRegistered::check($this->vehicle, $this->firstFleet);
    }

    /**
     * @When I try to register this vehicle into my fleet
     */
    public function iTryToRegisterThisVehicleIntoMyFleet()
    {
        try {
            RegisterVehicle\RegisterVehicle::do($this->vehicle, $this->firstFleet);
        } catch (\Exception $e) {
            $this->exception = $e;
        }
    }

    /**
     * @Then I should be informed this this vehicle has already been registered into my fleet
     */
    public function iShouldBeInformedThisThisVehicleHasAlreadyBeenRegisteredIntoMyFleet()
    {
        PHPUnit_Framework_Assert::assertInstanceOf(Infra\Exception\AlreadyInFleetException, $this->exception->getPrevious());
    }

    /**
     * @Given this vehicle has been registered into the other user's fleet
     */
    public function thisVehicleHasBeenRegisteredIntoTheOtherUsersFleet()
    {
        RegisterVehicle\RegisterVehicle::do($this->vehicle, $this->secondFleet);
    }

}
