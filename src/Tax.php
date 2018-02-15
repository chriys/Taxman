<?php

namespace Taxman;

class Tax
{
    private $amount;

    private $rates;

    private $taxes;

    private function __construct($amount, $rates)
    {
        $this->amount = $amount;
        $this->rates = $rates;
    }

    public static function create($amount, $taxes)
    {
        return new self($amount, $taxes);
    } 

    public static function of($amount, $tax)
    {
        return $amount * ($tax / 100);
    }
}
