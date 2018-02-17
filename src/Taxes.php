<?php

namespace Taxman;

use Taxman\Exceptions\NonNumericInputException;

class Taxes
{
    /**
     * The amount on which to calculate taxes.
     *
     * @var float
     */
    private $amount;

    /**
     * The taxe(s) to apply on the amount.
     *
     * @var mixed
     */
    private $taxes;

    public function __construct($amount, $taxes)
    {
        $this->amount = $this->parse($amount);

        $this->taxes = $this->generate(array_slice(func_get_args(), 1));
    }

    /**
     * Check if the amount is numeric otherwise
     * throw an exception.
     *
     * @param mixed $amount
     * @return NonNumericInputException
     */
    private function parse($amount)
    {
        if (! is_numeric($amount)) {
            throw new NonNumericInputException("The input: {$amount} is not numeric.");
        }

        return $amount;
    }

    /**
     * Generate an array of taxes.
     *
     * @param array $taxes
     * @return array
     */
    private function generate(array $taxes)
    {
        if (is_array($taxes[0])) {
            $taxes = $taxes[0];
        }

        return array_map(function ($tax) {
            return $this->parse($tax);
        }, $taxes);
    }

    /**
     * Create a new instance.
     *
     * @param mixed $amount
     * @param mixed ...$taxes
     * @return \Taxman\Taxes
     */
    public static function create($amount, ...$taxes)
    {
        return new self($amount, ...$taxes);
    }

    /**
     * Return an array with calculations details.
     *
     * @param mixed $amount
     * @param mixed ...$taxes
     * @return array
     */
    public static function calculate($amount, ...$taxes)
    {
        return static::create($amount, ...$taxes)->toArray();
    }

    /**
     * Calculate total taxes on amount.
     *
     * @param mixed $amount
     * @param mixed $taxes
     * @return mixed
     */
    public static function of($amount, ...$taxes)
    {
        return static::create($amount, ...$taxes)->sum();
    }

    /**
     * Output an array of calculations details.
     *
     * @return array
     */
    public function toArray()
    {
        return array_merge(
            ['sub_total' => (string) $this->amount],
            ['taxes_details' => $this->generateTaxesDetails()],
            [
                'taxes' => (string) $this->sum(),
                'total' => (string) $this->total(),
            ]
        );
    }

    /**
     * Generate an array of details name => amount.
     *
     * @return array
     */
    private function generateTaxesDetails()
    {
        return array_combine($this->taxes,
            array_map(function ($value) {
                return (string) $value;
            }, $this->values())
        );
    }

    /**
     * Get the sum of calculated taxes on an amount.
     *
     * @param mixed $amount
     * @param array $taxes
     * @return mixed
     */
    public function sum()
    {
        return array_sum($this->values());
    }

    /**
     * Get the list of calculates taxes.
     *
     * @return array
     */
    private function values()
    {
        return array_map(function ($tax) {
            return $this->taxFor($this->amount, $tax);
        }, $this->taxes);
    }

    /**
     * Calculate tax on amount.
     *
     * @param float $amount
     * @param float $tax
     * @return float
     */
    public function taxFor($amount, $tax)
    {
        return $amount * ($tax / 100);
    }

    /**
     * Get the total.
     *
     * @return float
     */
    public function total()
    {
        return $this->amount + $this->sum();
    }

    /**
     * Get the sub-total.
     *
     * @return float
     */
    public function subTotal()
    {
        return $this->amount;
    }

    /**
     * Get the list of taxes.
     *
     * @return array
     */
    public function lists()
    {
        return array_combine($this->taxes, $this->values());
    }
}
