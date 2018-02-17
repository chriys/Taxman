<?php

namespace Taxman;

use Taxman\Exceptions\NonNumericValueException;

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

    public static function create($amount, ...$taxes)
    {
        return new self($amount, ...$taxes);
    }

    /**
     * Check if the amount is numeric otherwise
     * throw an exception.
     *
     * @param mixed $amount
     * @return \InvalidArgumentException
     */
    private function parse($amount)
    {
        if (! is_numeric($amount)) {
            throw new NonNumericValueException('The Taxes class only accepts amount and taxes that are numeric. Input was: '.$amount);
        }

        return floatval($amount);
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
     * Get the sub-total.
     *
     * @return float
     */
    public function subTotal()
    {
        return floatval($this->amount);
    }

    /**
     * Get the total.
     *
     * @return float
     */
    public function total()
    {
        return floatval($this->amount + $this->sum());
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
        return (new self($amount, ...$taxes))->sum();
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
     * Get the list of taxes.
     *
     * @return array
     */
    public function lists()
    {
        return array_combine($this->taxes, $this->values());
    }

    /**
     * Get the list of calculates taxes.
     *
     * @return array
     */
    private function values()
    {
        return array_map(function ($tax) {
            return $this->amount * ($tax / 100);
        }, $this->taxes);
    }
}
