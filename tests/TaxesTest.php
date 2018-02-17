<?php

namespace Tests;

use Taxman\Taxes;
use PHPUnit\Framework\TestCase;

class TaxesTest extends TestCase
{
    /** @test */
    function it_creates_a_new_instance()
    {
        $sale = Taxes::create('10.00', ['4', '5']);

        $this->assertInstanceOf(Taxes::class, $sale);
        $this->assertObjectHasAttribute('amount', $sale);
        $this->assertObjectHasAttribute('taxes', $sale);
        $this->assertEquals(0.9, $sale->sum());

        $sale2 = Taxes::create('10.00', '4', '5');

        $this->assertInstanceOf(Taxes::class, $sale2);
        $this->assertObjectHasAttribute('amount', $sale2);
        $this->assertObjectHasAttribute('taxes', $sale2);
        $this->assertEquals(0.9, $sale2->sum());
    }

    /** @test */
    public function it_returns_list_of_taxes_values()
    {
        $taxes = new Taxes('10.00', ['1', '2', '3', '4', '5']);
        $this->assertArraySubset(
            [
                '1' => 0.1,
                '2' => 0.2,
                '3' => 0.3,
                '4' => 0.4,
                '5' => 0.5,
            ],
            $taxes->lists()
        );
        $this->assertEquals(1.5, $taxes->sum());

        $taxes2 = new Taxes('10.00', '1.25');
        $this->assertArraySubset(['1.25' => 0.125], $taxes2->lists());
        $this->assertEquals(0.125, $taxes2->sum());
    }

    /** @test */
    public function it_consider_second_argument_and_beyond_to_be_taxes()
    {
        $taxes = new Taxes('10.00', '1', '2', '3', '4', '5');

        $this->assertArraySubset(
            [
                '1' => 0.1,
                '2' => 0.2,
                '3' => 0.3,
                '4' => 0.4,
                '5' => 0.5,
            ],
            $taxes->lists()
        );
        $this->assertEquals(1.5, $taxes->sum());
    }

    /** @test */
    public function it_sums_taxes_calculated_on_amount()
    {
        $taxes = new Taxes('45.35', '4', '1.25', '5.725');

        $this->assertEquals(4.9771625, $taxes->sum());
    }

    /** @test */
    function it_builds_an_array_with_calculations_details()
    {
        $taxes = new Taxes('10', '1');

        $taxesDetails = $taxes->toArray();

        $this->assertArrayHasKey('sub_total', $taxesDetails);
        $this->assertArrayHasKey('taxes_details', $taxesDetails);
        $this->assertArrayHasKey('taxes', $taxesDetails);
        $this->assertArrayHasKey('total', $taxesDetails);
    }
    
}
