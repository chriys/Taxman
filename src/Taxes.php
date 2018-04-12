<?php

namespace Taxman;

use Taxman\Exceptions\NotFoundRateException;
use Taxman\Exceptions\NonNumericInputException;

class Taxes
{
    /**
     * Repository of provinces taxes definitions
     *
     * @var array
     */
    private $repository;

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

    public function __construct($amount, ...$taxes)
    {
        $this->repository = include __DIR__.'/../resources/rates.php';

        $this->amount = $this->parseNumber($amount);

        $this->taxes = $this->generate(...$taxes);
    }

    /**
     * Check if the amount is numeric otherwise
     * throw an exception.
     *
     * @param mixed $amount
     * @return NonNumericInputException
     */
    private function parseNumber($amount)
    {
        if (! is_numeric($amount)) {
            throw new NonNumericInputException("The input: {$amount} is not numeric.");
        }

        return $amount;
    }

    /**
     * Generate an array of taxes.
     *
     * @param mixed $taxes
     * @return array
     */
    private function generate($taxes)
    {
        if (func_num_args() == 1 && is_string($taxes)) {
            return $this->generateStateRates($taxes);
        }

        if (func_num_args() > 1 || ! is_array($taxes)) {
            $taxes = func_get_args();
        }

        return array_map(function ($tax) {
            return $this->parseNumber($tax);
        }, $taxes);
    }

    private function generateStateRates($state)
    {
        if (isset($this->repository[$state])) {
            return array_map(function($rate) {
                return $rate;
            }, $this->flattenArray(array_values($this->repository[$state])));
        }

        throw new NotFoundRateException("There is no tax rate definition with the name {$state}");
    }

    private function flattenArray($array)
    {
        if (!is_array($array)) {
            return $array;
        }

        $result = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, $value);
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
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
     * Json serialization of calculations details.
     *
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->toArray());
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
            return $this->evaluate($tax);
        }, $this->taxes);
    }

    /**
     * Evaluate tax on amount.
     *
     * @param float $tax
     * @return string
     */
    private function evaluate($tax)
    {
        return (string) $this->amount * ($tax / 100);
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

    public static function stateRateFor($state)
    {
        $rates = require __DIR__.'/../resources/rates.php';

        if (isset($rates[$state])) {
            return array_values($rates[$state]['state_rate'])[0];
        }

        throw new NotFoundRateException("There is no tax rate definition with the name {$state}");
    }

    public static function countryRateFor($state)
    {
        $rates = require __DIR__.'/../resources/rates.php';

        if (isset($rates[$state])) {
            return array_values($rates[$state]['country_rate'])[0];
        }

        throw new NotFoundRateException("There is no tax rate definition with the name {$state}");
    }
}
