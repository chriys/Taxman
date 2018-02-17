<?php

namespace Tests;

use Taxman\Taxes;
use PHPUnit\Framework\TestCase;

class CalculateTaxesTest extends TestCase
{
    /** @test */
    public function it_calculates_taxes_on_amount()
    {
        $taxes = Taxes::of('45.35', 4);
        $this->assertEquals(1.814, $taxes);

        $taxes = Taxes::of('45.35', [4, 1.25, 5.725]);
        $this->assertEquals(4.9771625, $taxes);

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

    /** @test */
    public function it_returns_an_array_with_sale_details()
    {
        $sale = Taxes::calculate('45.00', '1', '2', '3');

        $this->assertArraySubset(
            [
                'sub_total' => '45',
                'taxes_details' => [
                    '1' => '0.45',
                    '2' => '0.9',
                    '3' => '1.35',
                ],
                'taxes' => '2.7',
                'total' => '47.7',
            ],
            $sale
        );
    }
}
