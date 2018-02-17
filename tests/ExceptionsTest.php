<?php

namespace Tests;

use Taxman\Taxes;
use PHPUnit\Framework\TestCase;
use Taxman\Exceptions\NonNumericValueException;

class ExceptionsTest extends TestCase
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
}