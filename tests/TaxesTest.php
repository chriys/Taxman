<?php

namespace Tests;

use Taxman\Taxes;

class TaxesTest extends \PHPUnit_Framework_TestCase
{
   /** @test */
   function it_throws_exception_for_non_numeric_amount()
   {
        try {
            new Taxes('ABC12.00', 0);
        } catch (\InvalidArgumentException $e) {
            return;
        }

        $this->fail('A non numeric amount was entered but no exception was thrown.');
   }

   /** @test */
   function it_returns_list_of_taxes_values()
   {
        $taxes = new Taxes('10.00', ['1', '2', '3', '4', '5']);
        $this->assertArraySubset(
            [
                '1' => 0.1,
                '2' => 0.2,
                '3' => 0.3,
                '4' => 0.4,
                '5' => 0.5
            ],
            $taxes->lists()
        );
        $this->assertEquals(1.5, $taxes->sum());

        $taxes2 = new Taxes('10.00', '1.25');
        $this->assertArraySubset(['1.25' => 0.125], $taxes2->lists());
        $this->assertEquals(0.125, $taxes2->sum());
   }
   

   /** @test */
   function it_consider_second_argument_and_beyond_to_be_taxes()
   {
        $taxes = new Taxes('10.00', '1', '2', '3', '4', '5');

        $this->assertArraySubset(
            [
                '1' => 0.1, 
                '2' => 0.2, 
                '3' => 0.3, 
                '4' => 0.4, 
                '5' => 0.5
            ], 
            $taxes->lists()
        );
        $this->assertEquals(1.5, $taxes->sum());
   }
   

   /** @test */
   function it_sums_taxes_calculated_on_amount()
   {
        $taxes = new Taxes('45.35', '4', '1.25', '5.725');

        $this->assertEquals(4.9771625, $taxes->sum());
   }
   
   
}