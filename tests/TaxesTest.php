<?php

namespace Tests;

use Taxman\Taxes;
use ReflectionClass;
use PHPUnit\Framework\TestCase;

class TaxesTest extends TestCase
{
    /** @test */
    public function it_accepts_an_array_of_taxes()
    {
        $object = new Taxes('10.00', ['1', '2']);

        $getTaxes = function () {
            return $this->taxes;
        };
        $getTaxes = $getTaxes->bindTo($object, $object);
        $taxes = $getTaxes();
        
        $this->assertArraySubset(['1', '2'], $taxes);
    }
    
    /** @test */
    public function it_accepts_arguments_as_taxes()
    {
        $object = new Taxes('10.00', '1', '2', '3');

        $getTaxes = function () {
            return $this->taxes;
        };
        $getTaxes = $getTaxes->bindTo($object, $object);
        $taxes = $getTaxes();

        $this->assertArraySubset(['1', '2', '3'], $taxes);
    }
    
    /** @test */
    public function it_sums_taxes_calculated_on_amount()
    {
        $taxes = new Taxes('45.35', '4', '1.25', '5.725');

        $this->assertEquals(4.9771625, $taxes->sum());
    }

    /** @test */
    public function it_returns_list_of_evaluated_taxes()
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
    }

    /** @test */
    public function it_creates_a_new_instance()
    {
        $sale = Taxes::create('10.00', ['4', '5']);

        $this->assertInstanceOf(Taxes::class, $sale);
        $this->assertObjectHasAttribute('amount', $sale);
        $this->assertObjectHasAttribute('taxes', $sale);
    }

    /** @test */
    public function it_builds_an_array_with_calculations_details()
    {
        $taxes = Taxes::create('10', '1');

        $taxesDetails = $taxes->toArray();

        $this->assertArrayHasKey('sub_total', $taxesDetails);
        $this->assertArrayHasKey('taxes_details', $taxesDetails);
        $this->assertArrayHasKey('taxes', $taxesDetails);
        $this->assertArrayHasKey('total', $taxesDetails);
    }
}
