<?php

namespace Tests;

use Taxman\Taxes;

class CalculateTaxesTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    function it_calculates_tax_on_amount()
    {
       $tax = Taxes::of('12.00', 5.25);

       $this->assertEquals(0.63, $tax);
    }

    /** @test */
    function it_calculates_an_array_of_taxes_on_amount()
    {
        $taxes = Taxes::of('45.35', [4, 1.25, 5.725]);

        $this->assertEquals(4.9771625, $taxes);
    }

    /** @test */
    function it_calculates_total_taxes_passed_as_arguments()
    {
        $taxes = Taxes::of('45.35', '4', '1.25', '5.725');

        $this->assertEquals(4.9771625, $taxes);
    }

    

    // TODO: 
    // subTotal & total
    // tax list is an object ?
    // PACKAGIST
    // STYLECI
    // TRAVIS CI
    // README
    // Add DEV branch
    // create an instance with helper methods
    // instance return total taxes and each taxe with amount
    // manage package version
    // add changelog.md
    // Give name to taxes to identify
    // find taxes definitions from a config file or something alike for Canada provinces
    // look taxes in repository if not numeric
}
