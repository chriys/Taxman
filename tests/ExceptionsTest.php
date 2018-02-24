<?php

namespace Tests;

use Taxman\Taxes;
use PHPUnit\Framework\TestCase;
use Taxman\Exceptions\NotFoundRateException;
use Taxman\Exceptions\NonNumericInputException;

class ExceptionsTest extends TestCase
{
    /** @test */
    public function it_throws_exception_for_non_numeric_amount()
    {
        $this->expectException(NonNumericInputException::class);
        $this->expectExceptionMessage('The input: ABC12.00 is not numeric.');

        $taxes = new Taxes('ABC12.00', 0);
    }

    /** @test */
    public function it_throws_exception_for_non_numeric_taxes()
    {
        $this->expectException(NonNumericInputException::class);
        $this->expectExceptionMessage('The input: NonNumericTax is not numeric.');

        $taxes = new Taxes('50.00', ['NonNumericTax', '5', '2.99']);
    }

    /** @test */
    function it_throws_a_not_found_rate_exception()
    {
        $this->expectException(NotFoundRateException::class);
        $this->expectExceptionMessage('There is no tax rate definition with the name NonExistingRate');

        Taxes::stateRateFor('NonExistingRate');
    }
    
}