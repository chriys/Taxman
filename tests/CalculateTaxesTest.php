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

    /** @test */
    function it_returns_the_sub_total()
    {
        $taxes = new Taxes('45.35', '4', '1.25', '5.725');

        $this->assertEquals(4.9771625, $taxes->sum());
        $this->assertEquals(45.35, $taxes->subTotal());
    }

    /** @test */
    function it_calculates_sales_total()
    {
        $sale = new Taxes('45.35', '4', '1.25', '5.725');

        $this->assertEquals(4.9771625, $sale->sum());
        $this->assertEquals(45.35, $sale->subTotal());
        $this->assertEquals(50.3271625, $sale->total());
    }
    
    
    // TODO: 
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
