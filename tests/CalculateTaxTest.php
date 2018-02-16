<?php

namespace Tests;

use Taxman\Taxes;

class CalculateTaxTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    function it_calculates_tax_on_amount()
    {
       $tax = Taxes::of('12.00', 5.25);

       $this->assertEquals(0.63, $tax);
    }

    /** @test */
    function it_calculates_taxes_on_amount()
    {
        $taxes = Taxes::of('45.35', [4, 1.25, 5.725]);

        $this->assertEquals(4.9771625, $taxes);
    }
        
}
