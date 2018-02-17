<?php

namespace Tests;

use Taxman\Taxes;
use PHPUnit\Framework\TestCase;

class CalculateTaxesTest extends TestCase
{
    /** @test */
    public function it_calculates_tax_on_amount()
    {
        $tax = Taxes::of('12.00', 5.25);

        $this->assertEquals(0.63, $tax);
    }

    /** @test */
    public function it_calculates_an_array_of_taxes_on_amount()
    {
        $taxes = Taxes::of('45.35', [4, 1.25, 5.725]);

        $this->assertEquals(4.9771625, $taxes);
    }

    /** @test */
    public function it_calculates_total_taxes_passed_as_arguments()
    {
        $taxes = Taxes::of('45.35', '4', '1.25', '5.725');

        $this->assertEquals(4.9771625, $taxes);
    }

    /** @test */
    public function it_returns_the_sub_total()
    {
        $taxes = new Taxes('45.35', '4', '1.25', '5.725');

        $this->assertEquals(4.9771625, $taxes->sum());
        $this->assertEquals(45.35, $taxes->subTotal());
    }

    /** @test */
    public function it_calculates_sales_total()
    {
        $sale = new Taxes('45.35', '4', '1.25', '5.725');

        $this->assertEquals(4.9771625, $sale->sum());
        $this->assertEquals(45.35, $sale->subTotal());
        $this->assertEquals(50.3271625, $sale->total());
    }
}
