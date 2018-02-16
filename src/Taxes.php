<?php

namespace Taxman;

class Taxes
{
    private $amount;

    public function __construct($amount)
    {
        $this->amount = $this->enforceNumericCheck($amount);
    }

    private function enforceNumericCheck($amount)
    {
        if (!is_numeric($amount))
            throw new \InvalidArgumentException('The Taxes class only accepts amount that is numeric. Input was: ' . $amount);

        return $amount;
    }

    public static function of($amount, $taxes)
    {
        if (is_array($taxes)) {
            return array_sum(
                array_map(function($tax) use ($amount) {
                    return $amount * ($tax / 100);
                }, $taxes)
            );
        }
        
        return $amount * ($taxes / 100);
    }
}