<?php

namespace Tests;

use Taxman\Taxes;

class TaxesTest extends \PHPUnit_Framework_TestCase
{
   /** @test */
   function it_throws_exception_for_non_numeric_amount()
   {
        try {
            new Taxes('ABC12.00');
        } catch (\InvalidArgumentException $e) {
            return;
        }

        $this->fail('A non numeric amount was entered but no exception was thrown.');
   }
   
}