<?php

namespace Taxman;

class Taxes
{
    /**
     * The amount on which to calculate taxes
     *
     * @var float
     */
    private $amount;

    /**
     * The taxe(s) to apply on the amount
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
     * throw an exception
     *
     * @param mixed $amount
     * @return \InvalidArgumentException
     */
    private function parse($amount)
    {
        if (!is_numeric($amount))
            throw new \InvalidArgumentException('The Taxes class only accepts amount that is numeric. Input was: ' . $amount);

        return floatval($amount);
    }

    private function generate(array $taxes)
    {
        if (is_array($taxes[0])) {
            return $taxes[0];
        }

        return $taxes;
    }

    /**
     * Calculate total taxes on amount.
     *
     * @param mixed $amount
     * @param mixed $taxes
     * @return mixed
     */
    public static function of($amount, $taxes)
    {
        // if (func_num_args() > 2) {
            $instance = new self($amount,array_slice(func_get_args(), 1)[0]);

            return $instance->sum();
        // }

        // if (is_array($taxes)) {
        //     return array_sum(
        //         array_map(function($tax) use ($amount) {
        //             return $amount * ($tax / 100);
        //         }, $taxes)
        //     );
        // }
        
        // return $amount * ($taxes / 100);
    }

    /**
     * Get the sum of calculated taxes on an amount
     *
     * @param mixed $amount
     * @param array $taxes
     * @return mixed
     */
    public function sum()
    {
        var_dump($this->values());
        return array_sum($this->values());
    }

    /**
     * Get the list of taxes
     *
     * @return array
     */
    public function lists()
    {
        return array_combine($this->taxes, $this->values());
    }

    private function values()
    {
        return array_map(function($tax) {
            return $this->amount * ($tax / 100);
        }, $this->taxes);
    }
}