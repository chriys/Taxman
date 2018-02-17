<?php

namespace Tests;

use Taxman\Taxes;
use PHPUnit\Framework\TestCase;
use Taxman\Exceptions\NonNumericValueException;

class TaxesTest extends TestCase
{
    /** @test */
    public function it_throws_exception_for_non_numeric_amount()
    {
        $this->expectException(NonNumericValueException::class);
        $this->expectExceptionMessage('The Taxes class only accepts amount and taxes that are numeric.');

        $taxes = new Taxes('ABC12.00', 0);
    }

    /** @test */
    public function it_throws_exception_for_non_numeric_taxes()
    {
        $this->expectException(NonNumericValueException::class);
        $this->expectExceptionMessage('The Taxes class only accepts amount and taxes that are numeric.');

        $taxes = new Taxes('50.00', ['NonNumericTax', '5', '2.99']);
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
}
