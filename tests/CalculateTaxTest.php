<?php

namespace Tests;

use Taxman\Tax;

class CalculateTaxTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    function it_returns_an_object_with_tax_and_amount()
    {
        $taxes = Tax::create('100', 5.525);

        $this->assertInstanceOf(Tax::class, $taxes);
        $this->assertObjectHasAttribute('amount', $taxes);
        $this->assertObjectHasAttribute('rates', $taxes);
        $this->assertObjectHasAttribute('taxes', $taxes);
    }

    /** @test */
    function it_calculates_tax_on_amount()
    {
       $tax = Tax::of(100, 5.525);
       $this->assertEquals(5.525, $tax);
    }
    
    
}
